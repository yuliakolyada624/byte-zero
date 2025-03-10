<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Controllers;

use App\Libraries\MailSender;
use App\Modules\User\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegisterController;
use App\Modules\User\Entities\UserEntitie as User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Models\LoginModel;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\RuntimeException;
use CodeIgniter\I18n\Time;
use App\Libraries\SMSSender;
use App\Modules\Companies\Models\CompaniesModel;
use DateTime;
/**
 * Class RegisterController
 *
 * Handles displaying registration form,
 * and handling actual registration flow.
 */
class RegisterController extends ShieldRegisterController
{
    
    private string $type = Session::ID_TYPE_EMAIL_ACTIVATE;

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }


    /* 
    This method has been overridden due to a bad redirect. This is fixed here.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getRegisterRules();

        if (! $this->validateData($this->request->getPost(), $rules)) {
            //dd($this->validator->getErrors());
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        $user_id = $users->getInsertID();
        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($user_id);

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // domain
        $domain = substr(strrchr($user->email, "@"), 1);
        //
        $_CompaniesModel = new CompaniesModel();
        $_CompaniesModel->save([
            'owner_id' => $user_id,
            'company_name' => trim($this->request->getPost('company_name')),
            'domain' => $domain
        ]);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->to('accounts/auth/a/show'); // FIXed redirect
        }

        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
                ->with('message', lang('Auth.registerSuccess')); 
    }

    protected function getRegisterRules(): array
    {
        // dd(setting('Validation.user_registration') ); 

        return [
            'company_name' => [
                'label' =>  'Company Name',
                'rules' => 'required|trim|min_length[3]',
            ],
            'email' => [
                'label' =>  'Auth.email',
                'rules' => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret]',
            ],
            'register_agree' => [
                'label' =>  'Agree',
                'rules' => 'required',
            ],
            
            // 'password' => [
            //     'label'  => 'Auth.password',
            //     'rules'  => 'required|' . Passwords::getMaxLenghtRule() . '|strong_password',
            //     'errors' => [
            //         'max_byte' => 'Auth.errorPasswordTooLongBytes',
            //     ],
            // ],
            // 'password_confirm' => [
            //     'label' => 'Auth.passwordConfirm',
            //     'rules' => 'required|matches[password]',
            // ],
        ];
    }



    public function emailApprove($code, $user_id)
    {

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $users = $this->getUserProvider();
        $user = $users->find($user_id);


        if ($user === null) {
            //throw new RuntimeException('Cannot get the pending login User.');
            return redirect()->to(config('Auth')->logoutRedirect())->with('errors', 'Cannot get the pending login User.');
        }

        $identity = $this->getIdentity($user);

        if (is_null($identity)) {
            return redirect()->to(config('Auth')->logoutRedirect())->with('errors', 'Cannot get the pending login User.');
        }

        // No match - let them try again.
        if (!$authenticator->checkAction($identity, $code)) {
            session()->setFlashdata('error', lang('Auth.invalidActivateToken'));
            return $this->view(setting('Auth.views')['action_email_activate_show']);
        }

        $user = $authenticator->getUser();

        // Set the user active now
        $user->activate();

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));

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


    
    public function addPhone()
    {
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                ->with('message', lang('Auth.notHaveAccess'));
        }

        $data = [   'user' => $user, 
                    'title' => 'Add Phone number', 
                    'bodyClass' => ''
                ];
        return view('\App\Views\default\auth\add-phone', $data);
    }


    public function setPhone()
    {
        $currentUser = auth()->user();

        if (is_null($currentUser)) {     
            return redirect()->to(config('Auth')->logout())
                ->with('message', lang('Auth.notHaveAccess'));
        }

        $users = $this->getUserProvider();
        $rules = [
            'phone_number' => [
                'label' =>  'Auth.phone_number',
                'rules' => 'required|min_length[7]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
        // Save the user
       // $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        //$user->fill($this->request->getPost($allowedPostFields));
        $user->id = $currentUser->id;
        $user->phone_number_country  = $this->request->getPost('country_code');
        $user->phone_number = $this->request->getPost('phone_full'); // with code
        $phone_number = $this->request->getPost('phone_number'); // only phone

        $phone_country_code = substr($user->phone_number, 0, strlen($user->phone_number)-strlen($phone_number)); 
        $user->phone_number_code = $phone_country_code;

        //$group = (isset($user->groups[0]) ? $user->groups[0] : '');
        //d($group);
        //d($user);
        //d($currentUser);
       // dd($user->company_id);

        $data2FA = $this->get2FA();
        // save code  TODO encript it       
        $user->sms_code = $data2FA['smsCode'];
        $user->sms_expires_at = $data2FA['sms_expires_at'];
        
        try {
            $users->update($currentUser->id, $user);

            $smsService = new SMSSender();
            // TODO process errors
            $result = $smsService->send2FASMS($user->phone_number,  $data2FA['smsCode']);

            return redirect()->to(config('Auth')->redirectSet2FA())->with('message', lang('Auth.registerSuccess'));

        } catch (ValidationException $e) {
            //dd($users->errors());
            return redirect()->back()->with('errors', $users->errors());
        }

    }


    public function resend2FACode()
    {
        $currentUser = auth()->user();

        if (is_null($currentUser)) {
            $response = [
                'success' => false,
                'message' => lang('Auth.notHaveAccess'),
                'redirect' => config('Auth')->logout()
            ];
            return $this->response->setJSON($response);
        }

        $users = $this->getUserProvider();
        $user = $currentUser;

        $data2FA = $this->get2FA();
        // save code  TODO encript it       
        $user->sms_code = $data2FA['smsCode'];
        $user->sms_expires_at = $data2FA['sms_expires_at'];
        
        try {
            $users->update($currentUser->id, $user);

            $smsService = new SMSSender();
            // TODO process errors
            $result = $smsService->send2FASMS($user->phone_number,  $data2FA['smsCode']);

            $response = [
                'success' => true,
                'message' => 'Resend 2FA is successful',
                'result' => $result
                
            ];
            return $this->response->setJSON($response);
            
        } catch (ValidationException $e) {
            //dd($users->errors());
            $response = [
                'success' => false,
                'message' => $users->errors()
            ];
            return $this->response->setJSON($response);
        }
    }


    private function get2FA()
    {
        $data['smsCode'] = random_int(100000, 999999);
        $data['sms_expires_at'] = date('Y-m-d H:i:s', strtotime('+5 min'));

        return $data;
    }


    public function confirm2FA()
    {
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $data = [   'user' => $user, 
                    'title' => 'Confirm Phone Number', 
                    'bodyClass' => ''
                ];

        $group = (isset($user->groups[0]) ? $user->groups[0] : '');
        //dd($group);
        $view = '\App\Views\default\auth\invite-confirm-2FA-code';
        
        if($group=='superadmin'){
                    $view = '\App\Views\default\auth\confirm-2FA-code';
        }
        return view($view, $data);
    }



    public function check2FA()
    {
        $currentUser = auth()->user();

        if (is_null($currentUser)) {     
            return redirect()->to(config('Auth')->logout())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        // $currentUser->id;

        $securityCode = $this->request->getPost('security-code'); 

        $userModel = new UserModel();
        //$userModel = $this->getUserEntity();
        $user = $userModel->find($currentUser->id);

        //dd($user)
    
        if (!$user || $user->sms_code !== $securityCode) {
            return redirect()->back()->with('error', 'Security code is incorrect.');
        }

        // Checking if the code has expired
        $currentDateTime = new DateTime();
        $smsExpiresAt = new DateTime($user->sms_expires_at);

        if ($currentDateTime > $smsExpiresAt) {
            return redirect()->back()->with('error', 'The code has expired. Please request a new code.');
        }
    
        $user->sms_code = null;
        $userModel->save($user);

        $group = (isset($user->groups[0]) ? $user->groups[0] : '');
        //dd($group);
        
        if($group=='superadmin'){
            return redirect()->to('/accounts/new-password');
        }
    
        return redirect()->to('/accounts/invite-new-password');

    }


    public function newPassword($type='register')
    {
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $session = service('session');
        $session->set('type', $type);

        $data = [   'user' => $user, 
                    'title' => 'New Password', 
                    'bodyClass' => '',
                    'type'=>$type
                ];
        return view('\App\Views\default\auth\new-password', $data);
    }



    public function setNewPassword()
    {
        $currentUser = auth()->user();
       // dd($currentUser);

        if (is_null($currentUser)) {     
            return redirect()->to(config('Auth')->logout())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $users = $this->getUserProvider();
        $rules = $this->getValidationNewPasswordRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        $user->id = $currentUser->id;
        $user->last_password_update = date('Y-m-d H:i:s');

        //$group = (isset($user->groups[0]) ? $user->groups[0] : '');
        //d($group);
        //d($user);
        //d($currentUser);
       // dd($user->company_id);

        $session = service('session');
        $process_type = $session->get('type');

        //dd($process_type);
        
        try {
            $users->update($currentUser->id, $user);

            // Doing after password reset
            if($process_type && $process_type=='reset'){
                /** @var Session $authenticator */
                $authenticator = auth('session')->getAuthenticator();
                $authenticator->logout(); 

                return redirect()->route('password-changed')->with('message', 'Password changed successfully');
            }

            // Doing after password set in register
            if($user->inGroup('superadmin') && $currentUser->company_id==null){
                //SetUp account details for first login for Super Admin
                return redirect()->route('account-details')->with('message', lang('Auth.registerSuccess'));
            } else {
                return redirect()->to(config('Auth')->loginRedirect())->with('message', lang('Auth.registerSuccess'));
            }
        } catch (ValidationException $e) {
            //dd($users->errors());
            return redirect()->back()->with('errors', $users->errors());
        }

    }

    private function getValidationNewPasswordRules(){
        $rules = [
            'password' => [
                'label' =>  'Auth.password',
                'rules' => 'required|min_length[8]',
            ],
            'password_confirm' => [
                'label' =>  'Re-enter Password',
                'rules' => 'required|matches[password]|min_length[8]',
            ]
        ];

        return $rules;
    }



    public function resetPassword()
    {
        $data = [
            'title' => 'Reset Password',
            'bodyClass' => ''
        ];
        return view('\App\Views\default\auth\reset_password', $data);

    }

    public function processResetPassword(){
        $rules = [
            'email' => [
                'label' =>  'Company email',
                'rules' => 'required|valid_email|min_length[3]',
            ]
        ];
        //  'email' => config('Auth')->emailValidationRules,

        if (! $this->validateData($this->request->getPost(), $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim($this->request->getVar('email'));
        
        $users = $this->getUserProvider();
        
        $user = $users->findByCredentials(['email'=>$email]);
        if(!isset($user->id)){
            return redirect()->back()->withInput()->with('error', lang('Auth.invalidEmail', [$email]));
        }
        
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        // Delete any previous magic-link identities
        $identityModel->deleteIdentitiesByType($user, Session::ID_TYPE_MAGIC_LINK);

        // Generate the code and save it as an identity
        helper('text');
        $token = random_string('crypto', 20);

        $identityModel->insert([
            'user_id' => $user->id,
            'type'    => Session::ID_TYPE_MAGIC_LINK,
            'secret'  => $token,
            'expires' => Time::now()->addSeconds(setting('Auth.magicLinkLifetime'))->format('Y-m-d H:i:s'),
        ]);

        $MailSender = new MailSender();
		$MailSender->SendResetPasswordMail([
            'email' => $user->email,
            'token' => $token
        ]);
        

        
        $data = [
            'title' => 'Check Your Email',
            'bodyClass' => ''
        ];
        return view('\App\Views\default\auth\check-email', $data);
    }



    public function setNewResetPassword(): RedirectResponse
    {
        if (! setting('Auth.allowMagicLinkLogins')) {
            return redirect()->route('login')->with('error', lang('Auth.magicLinkDisabled'));
        }

        $token = $this->request->getGet('token');

        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identity = $identityModel->getIdentityBySecret(Session::ID_TYPE_MAGIC_LINK, $token);

        $identifier = $token ?? '';

        // No token found?
        if ($identity === null) {
            $this->recordLoginAttempt($identifier, false);

            $credentials = ['magicLinkToken' => $token];
            Events::trigger('failedLogin', $credentials);

            return redirect()->route('magic-link')->with('error', lang('Auth.magicTokenNotFound'));
        }

        // Delete the db entry so it cannot be used again.
        $identityModel->delete($identity->id);

        // Token expired?
        if (Time::now()->isAfter($identity->expires)) {
            $this->recordLoginAttempt($identifier, false);

            $credentials = ['magicLinkToken' => $token];
            Events::trigger('failedLogin', $credentials);

            return redirect()->route('magic-link')->with('error', lang('Auth.magicLinkExpired'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined
        if ($authenticator->hasAction($identity->user_id)) {
            return redirect()->route('auth-action-show')->with('error', lang('Auth.needActivate'));
        }

        // Log the user in
        $authenticator->loginById($identity->user_id);

        $user = $authenticator->getUser();

        $this->recordLoginAttempt($identifier, true, $user->id);

        // Give the developer a way to know the user
        // logged in via a magic link.
        session()->setTempdata('magicLogin', true);

        Events::trigger('magicLogin');

        // Get our login redirect url
        return redirect()->route('new-password/reset');
    }
	
    
    

    /**
     * @param int|string|null $userId
     */
    private function recordLoginAttempt(
        string $identifier,
        bool $success,
        $userId = null
    ): void {
        /** @var LoginModel $loginModel */
        $loginModel = model(LoginModel::class);

        $loginModel->recordLoginAttempt(
            Session::ID_TYPE_MAGIC_LINK,
            $identifier,
            $success,
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent(),
            $userId
        );
    }


    public function UserOnboarding($token ):RedirectResponse
    {
        if (! setting('Auth.allowMagicLinkLogins')) {
            return redirect()->route('login')->with('error', lang('Auth.magicLinkDisabled'));
        }

        
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identity = $identityModel->getIdentityBySecret(Session::ID_TYPE_MAGIC_LINK, $token);

        $identifier = $token ?? '';

        // No token found?
        if ($identity === null) {
            $this->recordLoginAttempt($identifier, false);

            $credentials = ['magicLinkToken' => $token];
            Events::trigger('failedLogin', $credentials);
            // TODO - new route
            return redirect()->route('reset-password')->with('error', lang('Auth.magicTokenNotFound'));
        }

        // Delete the db entry so it cannot be used again.
        $identityModel->delete($identity->id);

        // Token expired?
        if (Time::now()->isAfter($identity->expires)) {
            $this->recordLoginAttempt($identifier, false);

            $credentials = ['magicLinkToken' => $token];
            Events::trigger('failedLogin', $credentials);

            return redirect()->route('reset-password')->with('error', lang('Auth.magicLinkExpired'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined
        if ($authenticator->hasAction($identity->user_id)) {
            return redirect()->route('auth-action-show')->with('error', lang('Auth.needActivate'));
        }

        // Log the user in
        $authenticator->loginById($identity->user_id);

        $user = $authenticator->getUser();

        $this->recordLoginAttempt($identifier, true, $user->id);

        // Give the developer a way to know the user
        // logged in via a magic link.
        session()->setTempdata('magicLogin', true);

        Events::trigger('magicLogin');

        // Get our login redirect url
        return redirect()->route('onboarding-confirm');
    }


    public function UserOnboardingConfirm(){
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $group = (isset($user->groups[0]) ? $user->groups[0] : '');
        //dd($group);
        $view = '\App\Views\default\auth\invite-confirm';

        if($group=='assignee'){
            $view = '\App\Views\default\auth\invite-confirm-assignee';
        }

        $data = [   'user' => $user, 
                    'title' => 'New Password', 
                    'bodyClass' => ''
                ];
        return view($view , $data);
    }

    public function processUserOnboardingConfirm(){
        $currentUser = auth()->user();
        //dd($currentUser);
        

        if (is_null($currentUser)) {     
            return redirect()->to(config('Auth')->logout())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationOnboardRules();

        //dd($rules);
        if (! $this->validate($rules)) {
            redirect()->back()->with('errors', $this->validator->getErrors() );
            //return $this->fail($this->validator->getErrors(), 400);
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        $user->id = $currentUser->id;
        $user->user_status = 'Registered';
        $user->registered_on = date('Y-m-d H:i:s');
        $user->last_updated = date('Y-m-d H:i:s');
        $user->last_password_update = date('Y-m-d H:i:s');

        $user->work_phone_number_country  = $this->request->getPost('country_code');
        $user->work_phone_number = $this->request->getPost('phone_full'); // with code
        $work_phone_number = $this->request->getPost('work_phone_number'); // only phone

        //dd($work_phone_number);

        // Only exist in admin
        if(!is_null($work_phone_number)){
            $phone_country_code = substr($user->work_phone_number, 0, strlen($user->work_phone_number)-strlen($work_phone_number)); 
            $user->work_phone_number_code = $phone_country_code;
        }
        //echo '<pre>';
        //var_dump($user); die;
        
        // Set the user active
        $user->activate();


        try {
            $users->update($currentUser->id, $user);
            // Success!
            return redirect()->to(config('Auth')->inviteRedirect())
                    ->with('message', lang('Auth.registerSuccess')); 
            //return redirect()->route('invite-new-password')->with('message', lang('Auth.registerSuccess'));
        } catch (ValidationException $e) {
            //dd($users->errors());
            return redirect()->back()->with('errors', $users->errors());
        }
    }


    protected function getValidationOnboardRules(): array
    {

        $rules = [
            'id' => [
                'label' => 'User Id',
                'rules' => 'required',
            ],
            'first_name' => [
                'label' =>  'Auth.firstname',
                'rules' => 'required|trim|min_length[3]',
            ],
            'last_name' => [
                'label' =>  'Auth.lastname',
                'rules' => 'required|trim|min_length[3]',
            ],
            // 'middle_name' => [
            //     'label' =>  'Auth.middle_name',
            //     'rules' => 'if_exist|required|trim|min_length[3]',
            // ],
            'register_agree' => [
                'label' =>  'Agree',
                'rules' => 'required',
            ],        
        ];

        return $rules;
    }


    public function accountDetailsForm()
    {
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $data = [   'user' => $user, 
                    'title' => 'Account Holder Details', 
                    'bodyClass' => ''
                ];
        return view('\App\Views\default\auth\account-details', $data);
    }



    public function accountDetailsSave()
    {
        $currentUser = auth()->user();

        if (is_null($currentUser)) {     
            return redirect()->to(config('Auth')->logout())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $users = $this->getUserProvider();
        $rules = $this->getValidationAccountDetailsRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        $user->id = $currentUser->id;

        $user->work_phone_number_country  = $this->request->getPost('country_code');
        $user->work_phone_number = $this->request->getPost('phone_full'); // with code
        $phone_number = $this->request->getPost('work_phone_number'); // only phone

        $phone_country_code = substr($user->work_phone_number, 0, strlen($user->work_phone_number)-strlen($phone_number)); 
        $user->work_phone_number_code = $phone_country_code;

        // save service_industry to company
        $_CompaniesModel = new CompaniesModel();

        $company = $_CompaniesModel->where('owner_id', $currentUser->id)->first();
        // SET ID
        $user->company_id = $company->id;
        $user->user_status = 'Registered';
        $user->registered_on = date('Y-m-d H:i:s');
        $user->last_updated = date('Y-m-d H:i:s');

        try {
            $users->update($currentUser->id, $user);
            $_CompaniesModel
                ->where('owner_id', $currentUser->id)
                ->set(['service_industry' => trim($this->request->getPost('service_industry'))])
                ->update();

            return redirect()->to(config('Auth')->loginRedirect())->with('message', lang('Auth.registerSuccess'));

        } catch (ValidationException $e) {
            return redirect()->back()->with('errors', $users->errors());
        }

    }

    

    protected function getValidationAccountDetailsRules(): array
    {
        return [
            'first_name' => [
                'label' =>  'Auth.firstname',
                'rules' => 'required|trim|min_length[3]',
            ],
            'last_name' => [
                'label' =>  'Auth.lastname',
                'rules' => 'required|trim|min_length[3]',
            ],
            'service_industry' => [
                'label' =>  'Service Industry',
                'rules' => 'required|trim|min_length[3]',
            ],
            'work_phone_number' => [
                'label' =>  'Work Phone Number',
                'rules' => 'required|trim|min_length[3]',
            ],
            
        ];
    }
    

    
    public function passwordChanged()
    {
        $data = [  
                    'title' => 'Password changed successfully', 
                    'bodyClass' => ''
                ];
        return view('\App\Views\default\auth\password-changed', $data);
    }


    public function inviteUsersSave()
    {
        // Get the raw JSON input and decode it into a PHP array
        $jsonData = $this->request->getJSON(true); // Decodes JSON into an associative array
        $invites = $jsonData['invites'] ?? []; // Extract 'invites' key from the JSON data

        // If no invites are provided, return an error
        if (empty($invites)) {
            return $this->fail('No invite data provided.', 400);
        }

        $post_users = [];
        $validation_errors = [];

        // Iterate over each invite and collect user data
        foreach ($invites as $index => $invite) {
            $first_name = $invite['first_name'] ?? null;
            $last_name = $invite['last_name'] ?? null;
            $email = $invite['email'] ?? null;
            $role = $invite['role'] ?? null;
            $job_title = $invite['job_title'] ?? null;

            // Custom validation for each user
            $user_errors = [];

            if (empty($first_name)) {
                $user_errors['first_name'] = "First name is required for user at index $index.";
            }

            if (empty($last_name)) {
                $user_errors['last_name'] = "Last name is required for user at index $index.";
            }

            if (empty($email)) {
                $user_errors['email'] = "Email is required for user at index $index.";
            } /*elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user_errors['email'] = "Invalid email format for user at index $index.";
            }*/

            if (empty($role)) {
                $user_errors['role'] = "Role is required for user at index $index.";
            }

            if (empty($job_title)) {
                $user_errors['job_title'] = "Job title is required for user at index $index.";
            }

            // If there are any errors for this user, add them to the validation_errors array
            if (!empty($user_errors)) {
                $validation_errors["user_$index"] = $user_errors;
            } else {
                // Collect valid user data
                $post_users[] = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'role' => $role,
                    'job_title' => $job_title,
                ];
            }
        }

        // If there are any validation errors, return them
        if (!empty($validation_errors)) {
            return $this->fail($validation_errors, 400);
        }

        // Process each valid user invite
        foreach ($post_users as $user) {
            $this->processInviteUser($user);
        }

        return $this->respond(['success' => true], 200);
    }




    private function processInviteUser($userData)
    {

        $currentUser = auth()->user();
        // dd($currentUser);

        $company_id = $currentUser->company_id;

        $companiesModel = new \App\Modules\Companies\Models\CompaniesModel();
        $company_data = $companiesModel->find($company_id);


        // Save the user
        $users = $this->getUserProvider();

        $user = $this->getUserEntity();
        $user->fill($userData);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        helper('general');
        $password = random_password();
        $user->password = $password;
        $user->company_id = $company_id;

        // set full email
        $user->email = $user->email . '@' . $company_data->domain;

        $user->user_status = 'Invited';


        // var_dump($user->email);
        //var_dump($user); 
        //  return;

        try {
            $users->insert($user);
            $user = $users->findById($users->getInsertID());
            //dd($user);
            // TODO limit or filter this
            $user->addGroup($userData['role']);


            /** @var UserIdentityModel $identityModel */
            $identityModel = model(UserIdentityModel::class);

            // Delete any previous magic-link identities
            $identityModel->deleteIdentitiesByType($user, Session::ID_TYPE_MAGIC_LINK);

            // Generate the code and save it as an identity
            helper('text');
            $token = random_string('crypto', 20);

            $identityModel->insert([
                'user_id' => $user->id,
                'type' => Session::ID_TYPE_MAGIC_LINK,
                'secret' => $token,
                // 14 days
                'expires' => \CodeIgniter\I18n\Time::now()->addSeconds(3600 * 24 * 14)->format('Y-m-d H:i:s'),
            ]);


            $MailSender = new MailSender();
            $MailSender->SendInviteMail([
                'first_name' => $user->first_name,
                'email' => $user->email,
                'password' => $password,
                'company_name' => $company_data->company_name,
                'code' => $token,
                'user' => $user,
            ]);
        } catch (ValidationException $e) {
            return $this->fail($users->errors(), 400);
        }

    }


    public function getUserInviteValidationRules(){
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'role'       => 'required',
            'job_title'  => 'required'
        ];  
    }



    public function inviteNewPassword($type='register')
    {
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                    ->with('message', lang('Auth.notHaveAccess'));
        }

        $session = service('session');
        $session->set('type', $type);

        $data = [   'user' => $user, 
                    'title' => 'New Password', 
                    'bodyClass' => '',
                    'type'=>$type
                ];
        return view('\App\Views\default\auth\invite-new-password', $data);
    }

        
    public function inviteAddPhone()
    {
        $user = auth()->user();
        if (is_null($user)) {     
            return redirect()->to(config('Auth')->logoutRedirect())
                ->with('message', lang('Auth.notHaveAccess'));
        }

        $data = [   'user' => $user, 
                    'title' => 'Add Phone number', 
                    'bodyClass' => ''
                ];
        return view('\App\Views\default\auth\invite-add-phone', $data);
    }



}
