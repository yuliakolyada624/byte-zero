<?php 

namespace App\Modules\User\Controllers;

use App\Modules\Countries\Models\CountriesModel;
use App\Modules\Offices\Models\OfficesModel;
use App\Modules\User\Controllers\RegisterController;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\ValidationException;
use App\Modules\User\Models\UserModel;
use App\Modules\User\Entities\UserEntitie as UserUserEntitie;
use App\Modules\Notifications\Models\NotificationsModel;
use App\Libraries\MailSender;
use App\Modules\Companies\Models\CompaniesModel;
use App\Modules\User\Models\JobTitleModel;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\Files\FileCollection;
use CodeIgniter\Files\File;

//use CodeIgniter\Shield\Authentication\Actions\EmailActivator;
use CodeIgniter\Shield\Models\UserIdentityModel;

class AccountController extends RegisterController
{
    use ResponseTrait;

    private $user;
    private $userModel;

    private $notificationsModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        
        $this->notificationsModel = new NotificationsModel();
        // TODO - check for json req
        $this->check_user();
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): UserUserEntitie
    {
        return new UserUserEntitie();
    }


    public function check_user(){
        $user = auth()->user();
        if (!is_null($user)) {
            $this->user = $user;
        } else {
            return $this->failUnauthorized(lang('Auth.successLogout'));
        }
    }


    
    public function editProfileView(){
        
        $select = $this->getSelects();

        $companiesModel = new CompaniesModel();
        $company = $companiesModel->find($this->user->company_id);

        $data = [   'user' => $this->user, 
                    'company' => $company,
                    'select'=>$select,
                    'title' => 'Edit My Profile',
                    'bodyClass' => 'account-page header-offset'
                ];

        return view('Account/Profile', $data);
    }

 
    public function notifications(){
        
        $NotificationsList = $this->notificationsModel->Where('user_id', $this->user->id)->Where('status<3')->orderBy('id', 'desc')->paginate(20);

        $data = [   'user' => $this->user,
                    'NotificationsList'=>$NotificationsList, 
                    'pager'=>$this->notificationsModel->pager, 
                    'title' => 'Notifications', 
                    'bodyClass' => 'account-page header-offset' 
                ];
        return view('Account/Notifications', $data);
    }


    public function notificationsFilter($filter=false){
        // d($filter);

        $statuses = ['unread'=>1, 'read'=>2, 'archived'=>3];
        $types = ['System Message', 'Rewards Update', 'Confirmed Booking', 'Pending Booking', 'Cancelled Booking'];

        if(!$filter || $filter=='all'){
            $this->notificationsModel->Where('status<3');
        }
        
        if(array_key_exists($filter, $statuses)){
          //  dd($statuses[$filter]);
            $this->notificationsModel->Where('status', $statuses[$filter]);
        }
        if(in_array($filter, $types)){
            $this->notificationsModel->Where('type', $filter);
        }
        $NotificationsList = $this->notificationsModel->Where('user_id', $this->user->id)->orderBy('id', 'desc')->paginate(20);
       // dd($NotificationsList);

        $data = [   'user' => $this->user, 
                    'NotificationsList'=>$NotificationsList, 
                    'pager'=>$this->notificationsModel->pager, 
                    'title' => 'Notifications', 
                    'bodyClass' => 'account-page header-offset' 
                ];
        return view('Account/Notifications', $data);

    }

    public function profileSave(){
        $users = $this->getUserProvider();
        $rules = $this->getValidationRules();

        if (! $this->validate($rules)) {
            $errors = $this->validator->getErrors();
            if (isset($errors['zip_code']) && ($errors['zip_code'] == "Validation.1")) {
                $errors['zip_code'] = 'Invalid ZIP/Postal code format for the selected country';
            }
            return $this->fail($errors, 400);
        }
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        $country_model = new CountriesModel();
        $user->country = $country_model->getNameByAlpha2($this->request->getPost('country_a2code'));
        $user->password_change_frequency = ($this->request->getPost('profile_passperiod_enable') == 'true') ? $this->request->getPost('pass_period') : NULL;
        $user->permanently_delete_notifications_older_than = $this->request->getPost('exclude_notifications_from_header');

        $user->id = $this->user->id;

        try {
            $users->update($this->user->id, $user);
        } catch (ValidationException $e) {
            return $this->fail($users->errors(), 400);
        }

        $companiesModel = new CompaniesModel();
        $companyData = [
            'legal_entity_name' => $this->request->getPost('legal_entity_name')
        ];

        $companiesModel->update($this->user->company_id, $companyData);

        return $this->respond(['success'=>true], 200);
    }


    public function profilePasswordUpdate(){
    
        $users = $this->getUserProvider();
        $rules = $this->getValidationPasswordRules();
        //dd($rules);
        if (! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        //var_dump($user); die;
        try {
            $users->update($this->user->id, $user);
        } catch (ValidationException $e) {
            return $this->fail($users->errors(), 400);
        }

        return $this->respond(['success'=>true], 200);
    }


    /**
     *  Update user photo
     *
     */
    public function updateUserPhoto()
    {
        $user = $this->user; //$this->userModel->find($this->user->id);
        $validationRule = [
            'avatar' => [
                'label' => 'Image File',
                'rules' => 'uploaded[avatar]'
                . '|is_image[avatar]'
                . '|mime_in[avatar,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                . '|max_size[avatar,1000]'
                . '|max_dims[avatar,5000,5000]',
            ],
        ];
        if (! $this->validate($validationRule)) {

            return $this->setResponseFormat('json')->respond($this->validator->getError('avatar'), 400);
        }

        $img = $this->request->getFile('avatar');

        if (!$img->hasMoved()) {
            $users = $this->getUserProvider();

            $filepath = WRITEPATH . 'uploads/' . $img->store('users/avatars/' . $user->id);
            $uploaded_fileinfo = new File($filepath);
            $data['avatar'] = $uploaded_fileinfo->getFilename();
            $users->update($user->id, $data);

            // clear cache for thumb_ *
            $dir = WRITEPATH . 'uploads/users/avatars/' . $user->id;
            $files = new FileCollection([$dir]);
            $files->retainPattern('thumb_*');
            $to_remove_files = $files->get();
            foreach ($to_remove_files as $file) {
                @unlink($file);
            }

            return $this->setResponseFormat('json')->respond(['error' => false]);
        }

        return $this->setResponseFormat('json')->respond(['error' => true], 400);
    }


    /**
     * В Get options data to Selects
     *
     * @return array
     */
    private function getSelects()
    {
        $select = [];
        $select['countries'] = $this->userModel->get_countries_list();
        $select['currencies'] = $this->userModel->get_currencies_list();
        $select['companies'] = $this->userModel->get_companies_list();
        $select['states'] = $this->userModel->get_states_list();
        $select['provinces'] = $this->userModel->get_provinces_list();
        $select['languages'] = config('App')->supportedLang;

        // Job titles
        $job_title_model = new JobTitleModel();
        $job_titles = $job_title_model->getJobTitles(auth()->user()->company_id);
        $select['job_titles'] = $job_titles;

        return $select;
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array[]
     */
    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();

        unset($rules['email']);
        unset($rules['username']);
        unset($rules['password']);
        unset($rules['password_confirm']);
        unset($rules['language']);
        unset($rules['currency']);
        unset($rules['country']);
        unset($rules['nationality']);
        unset($rules['state']);
        unset($rules['province']);
        unset($rules['postal_code']);
        unset($rules['email_notifications_for_missed_alerts']);

        $rules['country_a2code']['rules'] = 'trim|required';
        $rules['district']['rules'] = 'trim|required';
        $rules['employee_id']['rules'] = 'trim|required';
        $rules['job_title']['rules'] = 'trim|required';
        $rules['job_title']['rules'] = 'trim|required';
        $rules['mobile_phone']['rules'] = 'trim|required';
        $rules['office_name']['rules'] = 'trim|required';
        $rules['legal_entity_name']['rules'] = 'trim';
        $rules['profile_passperiod_enable']['rules'] = 'trim|required';
        $rules['zip_code'] = [
            'label' => 'ZIP Code',
            'rules' => [
                'permit_empty',
                function ($zip, $fields, $data) {
                    if (isset($fields['country_a2code']) && empty($fields['country_a2code'])) {
                        return true;
                    }

                    $country_a2code = strtolower($fields['country_a2code']);
                    
                    if ($country_a2code === 'us') {
                        return preg_match('/^\d{5}(-\d{4})?$/', $zip) === 1;
                    } elseif ($country_a2code === 'ca') {
                        return preg_match('/^[A-Z]\d[A-Z] \d[A-Z]\d$/', strtoupper($zip)) === 1;
                    }

                    return false;
                },
            ]
        ];
        
        return $rules;
    }


    /**
     * Returns the rules that should be used for validation.
     *
     * @return array[]
     */
    protected function getValidationPasswordRules(): array
    {

        $rules = [
            'id' => [
                'label' => 'User Id',
                'rules' => 'required',
            ],
            'current_password' =>[
                'label' =>  'Auth.currentPassword',
                'rules' => 'required',
            ],
            'password' => [
                'label' =>  'Auth.password',
                'rules' => 'required',
            ],
            'password_confirm' => [
                'label' =>  'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ]
        ];

        return $rules;
    }
}
