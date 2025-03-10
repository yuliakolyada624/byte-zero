<?php 

namespace App\Modules\User\Controllers;



use App\Modules\User\Controllers\RegisterController;

use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Files\File;

use App\Modules\User\Models\UserModel;
use App\Modules\User\Entities\UserEntitie as UserUserEntitie;
use CodeIgniter\Files\FileCollection;
use App\Modules\Companies\Models\CompaniesModel;

class AdminUserController extends RegisterController
{
    private $user;
    private $userModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
       $this->userModel = new UserModel();
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
       // d($user);

        if (!is_null($user)) {
            $this->user = $user;
        } else {
            dd(lang('Auth.successLogout'));
        }
    }

    
    public function editProfileView(){
        
        $select = $this->getSelects();
        
        $data = [ 'user' => $this->user,'select'=>$select,  'title' => 'Edit My Profile', 'view' => 'user/profile'];
        return view('Admin/User/profile', $data);
    }


    public function editProfileByIdView($user_id){
        $this->user = $this->userModel->find($user_id);
        
        $select = $this->getSelects();
        
        $data = [ 'user' => $this->user, 'select'=>$select, 'title' => 'Edit User Profile'];
        return view('Admin/User/profile', $data);
    }


    private function getSelects()
    {
        $select = [];
        $select['countries'] = $this->userModel->get_countries_list();
        $select['currencies'] = $this->userModel->get_currencies_list();
        $select['companies'] = $this->userModel->get_companies_list();
        $select['states'] = $this->userModel->get_states_list();
        $select['provinces'] = $this->userModel->get_provinces_list();
        $select['languages'] = config('App')->supportedLang;
        return $select;
    }

   
    public function profileSave(){
        //$this->userModel
        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        //dd($rules);

        if (! $this->validate($rules)) {
            return redirect()->to('/user/edit-profile/'.$this->request->getPost('id') )->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

       //dd($user);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->update($user->id, $user);
        } catch (ValidationException $e) {
            return redirect()->to('/user/edit-profile/'.$user->id)->withInput()->with('errors', $users->errors());
        }

        return redirect()->to('/user/edit-profile/'.$user->id)->withInput()->with('sucsess', 'Saved');
    }


    /**
     * Returns the rules that should be used for validation.
     *
     * @return array[]
     */
    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        //dd($rules);
        $rules['email']['rules'] = str_replace('is_unique[auth_identities.secret]', 'is_unique[auth_identities.secret,user_id,{id}]', $rules['email']['rules']);
        $rules = array_merge($rules, [
            'id' => [
                'label' => 'User Id',
                'rules' => 'required',
            ],
        ]);
        $rules['middle_name']['rules'] = 'trim';
        $rules['middle_name']['label'] = 'Middle name';
        
        unset($rules['username']);

        // If not Admin - do not save pass
        if(! auth()->user()->can('admin.access')){
            unset($rules['password']);
            unset($rules['password_confirm']);
        } else {
            $rules['password']['rules'] = 'required_with[password_confirm]';
            $rules['password_confirm']['rules'] = 'required_with[password]';   
        }
        // If system - save company and business unit data
        if (auth()->user()->can('system.access')) {
            $rules['company_id']['rules'] = 'trim';
            $rules['business_unit_id']['rules'] = 'trim';
            $rules['department_id']['rules'] = 'trim';
            $rules['role_id']['rules'] = 'trim';
        }
        
        return $rules;      
    }


    public function updateUserAvatar($user_id)
    {
        $user = $this->userModel->find($user_id);
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

        if (! $img->hasMoved()) {
            $users = $this->getUserProvider();
          
            $filepath = WRITEPATH . 'uploads/' . $img->store('users/avatars/'.$user->id);
            $uploaded_fileinfo = new File($filepath);
            $data['avatar'] = $uploaded_fileinfo->getFilename();
            $users->update($user->id, $data);

            // clear cache for thumb_ *
            $dir = WRITEPATH . 'uploads/users/avatars/'.$user->id;
            $files = new FileCollection([$dir]);
            $files->retainPattern('thumb_*');
            $to_remove_files = $files->get();
            foreach($to_remove_files as $file){
                @unlink($file);
            }

            return $this->setResponseFormat('json')->respond(['error' => false]);    
        }
        
        return $this->setResponseFormat('json')->respond(['error' => true], 400);
    }

    /**
     * @param mixed $user_id
     * @api http://host.com/user/profile-avatar/{ID}?width={Width}&height={height}&background={000000}&color={ffffff}
     * @return \CodeIgniter\HTTP\Response|bool|string
     */
    public function getUserAvatar($user_id=null)
    {

        $width = ( $this->request->getVar('width') ?? 100 );
        $height = ( $this->request->getVar('height') ?? 100 );
        $color = '#'.( $this->request->getVar('color') ?? '148BDF' );
        
        $user = false;

        // System
        if($user_id==='0'){
            $user = new \stdClass();
            $user->id = 0;
            $user->first_name = "System";
            $user->last_name = "";
            $user->avatar = "";
            $user->middle_name = "";
        } else {
        
            if($user_id){
                $user = $this->userModel->find($user_id);
            } else {
                $user = auth()->user();
            }

        }

        if (!$user) {
            return $this->failNotFound('User cannot be found.');
        }

        // Config templete colors
        $color_array = array('FFFFFF'); // '34c38f', '50a5f1', 'f1b44c', 'f46a6a', '74788d'
        $color_count = count($color_array);
        $color_index = crc32($user->first_name.' '.$user->last_name) % $color_count;
        $user_color = $color_array[$color_index];
        // Param or user color
        $background = '#'.( $this->request->getVar('background') ?? $user_color );
        
        $avatar_file = WRITEPATH . 'uploads/users/avatars/'.$user->id.'/'.$user->avatar;
        $avatar_thumb_file = WRITEPATH . 'uploads/users/avatars/'.$user->id.'/thumb_'.$width.'x'.$height.'_'.$user->avatar;

        // check cache thumb
        if (file_exists($avatar_thumb_file)) {
            return file_get_contents($avatar_thumb_file);
        }
        
        // REF: https://github.com/LasseRafn/php-initial-avatar-generator
        if (file_exists($avatar_file)) {

            $image = \Config\Services::image();

            try {
                $image->withFile($avatar_file)
                    ->fit($width, $height, 'center')
                    ->save($avatar_thumb_file);

                return file_get_contents($avatar_thumb_file);
            } catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
                echo $e->getMessage();
            }

            
        }
        

        $avatar = new \LasseRafn\InitialAvatarGenerator\InitialAvatar();

        $image = $avatar->name($user->first_name.' '.$user->middle_name.' '.$user->last_name)
                ->length(3)
                //->size($height)
                ->background($background)
                ->color($color)
                ->fontSize(0.4)
                ->generate()
                ->stream('png', 90);
        echo $image;
    }

    

    public function list()
    {
        if (auth()->user()->can('system.access')) {
            $users = $this->userModel->orderBy('id', 'DESC')->paginate(10);
        } else {
            $user = auth()->user();
            $users = $this->userModel->Where('company_id', $user->company_id)->orderBy('id', 'DESC')->paginate(10);
        }
        
        $data = [ 'users' => $users, 'pager'=>$this->userModel->pager, 'title' => 'User List', 'view' => 'user/user_list'];
        return view('Admin/User/user_list', $data);
    }

    public function invite()
    {

        $select = $this->getSelects();
        
        $data = [ 'select'=>$select,  'title' => 'Invite user'];
        return view('Admin/User/invite', $data);
    }



    public function createProfile()
    {
        $users = $this->getUserProvider();
        $rules = $this->getCreateValidationRules();

        if (! $this->validate($rules)) {
            return redirect()->to('/user/invite/')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

       //dd($user);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        helper('general');
        $pass = random_password();
        $user->password = $pass;

        // company 
        $company = $this->request->getVar('company');
        $company_id = $this->request->getVar('company_id');
        $companiesModel = new CompaniesModel();
        if (!$company_id) {
            // Create new company
            $companiesModel->insert([  'name'=>$company,
                                       'description'=>$this->request->getVar('company_description'),
                                       'default_tpt_value'=>$this->request->getVar('default_tpt_value')
                                    ]);
            $company_id = $companiesModel->getInsertID();
        }
        $company_data = $companiesModel->find($company_id);
        $user->company_id = $company_id; 

        try {
            $users->insert($user);
            $user = $users->findById($users->getInsertID());
            //dd($user);
            $user->addGroup( $this->request->getVar('user_type') );

            $email = \Config\Services::email();
            $email->setFrom('olexandr@med-test.ai', 'Alex Dev Test');
            $email->setTo($user->email);

            $email->setSubject('Invite to Med-Test');
            
            $template = view("email/invite", [
                'first_name' => $user->first_name,
                'company_name' => $company_data->name,
                'email' => $user->email,
                'password' => $pass,
            ]);
            $email->setMessage($template);

            $email->send();
        } catch (ValidationException $e) {
            return redirect()->to('/user/invite/')->withInput()->with('errors', $users->errors());
        }

        return redirect()->to('/user/list/')->with('sucsess', 'User Invited');
    }


    protected function getCreateValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['email']['rules'] = str_replace('is_unique[auth_identities.secret]', 'is_unique[auth_identities.secret,user_id,{id}]', $rules['email']['rules']);
        // $rules['username']['rules'] = str_replace('is_unique[users.username]', 'is_unique[users.username,id,{id}]', $rules['username']['rules']);
        $rules['company']['rules'] = 'required_without[company_id]';
        $rules['company']['label'] = 'Company';
        $rules['company_id']['rules'] = 'required_without[company]';
        $rules['company_id']['label'] = 'Select Company';
        // re-assign rule for last name
        $rules['last_name']['rules'] = 'trim';

        $rules['middle_name']['rules'] = 'trim';
        $rules['middle_name']['label'] = 'Middle name';
        
        unset($rules['username']);
        unset($rules['phone_number']);
        unset($rules['password']);
        unset($rules['password_confirm']);
        return $rules;      
    }


    public function deleteProfileById(){

        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();

        $user_id = $this->request->getVar('id');

        $res = $users->delete($user_id, true);

        if($res){
            $data = [
                'success' => true,
                'msg'     => 'The data deleted successfully',
            ];
        } else {
            $data = [
                'success' => false,
                'msg'     => 'Error deleting the data',
            ];
        }

        return $this->response->setJSON($data);
    }




}
