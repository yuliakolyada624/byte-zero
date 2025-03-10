<?php

declare(strict_types=1);

namespace App\Modules\User\Actions;

use CodeIgniter\Shield\Authentication\Actions\ActionInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Exceptions\RuntimeException;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Traits\Viewable;

use App\Libraries\SMSSender;
use Config\Services;

/**
 * Class Sms2FA
 *
 * Sends an SMS to the user with a code to verify their account.
 */
class Sms2FA implements ActionInterface
{
    use Viewable;

    private string $type = 'sms2FA';

    /**
     * Displays the "Hey we're going to send you a number to your email"
     * message to the user with a prompt to continue.
     * 
     * @return RedirectResponse|string
     */
    public function show()
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            //  throw new RuntimeException('Cannot get the pending login User.');
            return redirect()->route('auth-action-show')->with('error', lang('Auth.need2FA'));
        }

        $code = $this->createIdentity($user);
        $smsService = new SMSSender();

        // TODO process errors
        $result = $smsService->send2FASMS($user->phone_number,  $code);


        return $this->view(setting('Auth.views')['action_sms_2fa'], ['user' => $user]);
    }

    /**
     * Generates the random number, saves it as a temp identity
     * with the user, and fires off an email to the user with the code,
     * then displays the form to accept the 6 digits
     *
     * @return RedirectResponse|string
     */
    public function handle(IncomingRequest $request)
    {
        // re-send SMS 
        
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();

        //dd($user);

        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

       
        $identity = $this->getIdentity($user);

        if (! $identity instanceof UserIdentity) {
            return redirect()->route('auth-action-show')->with('error', lang('Auth.need2FA'));
        }

        
        $new_identity = $this->createIdentity($user);

        $response = [
            'success' => true,
            'message' => 'Resend 2FA is successful',
            'result' => ($new_identity ? true : false)
            
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
        
    }

    /**
     * Attempts to verify the code the user entered.
     *
     * @return RedirectResponse|string
     */
    public function verify(IncomingRequest $request)
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $postedToken = $request->getPost('security-code');

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        $identity = $this->getIdentity($user);

        // Token mismatch? Let them try again...
        if (! $authenticator->checkAction($identity, $postedToken)) {
            session()->setFlashdata('error', 'Invalid code. Try again.');

            return $this->view(setting('Auth.views')['action_sms_2fa']);
        }

         // Get our login redirect url
         return redirect()->to(config('Auth')->loginRedirect());

    }

    /**
     * Creates an identity for the action of the user.
     *
     * @return string secret
     */
    public function createIdentity(User $user):string
    {
         /** @var UserIdentityModel $identityModel */
         $identityModel = model(UserIdentityModel::class);

         // Delete any previous identities for action
         $identityModel->deleteIdentitiesByType($user, $this->type);
 
         $generator = static fn (): string => strval(random_int(100000, 999999));
 
         return $identityModel->createCodeIdentity(
             $user,
             [
                 'type'  => $this->type,
                 'name'  => 'login',
                 'extra' => lang('Auth.need2FA'),
             ],
             $generator
         );
    }


     /**
     * Returns an identity for the action of the user.
     */
    private function getIdentity(User $user): ?UserIdentity
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        return $identityModel->getIdentityByType(
            $user,
            $this->type
        );
    }

    /**
     * Returns the string type of the action class.
     */
    public function getType(): string
    {
        return $this->type;
    }

  
}
