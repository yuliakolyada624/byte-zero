<?php

namespace App\Modules\User\Controllers;

use App\Modules\User\Controllers\RegisterController;
use App\Modules\User\Models\UserModel;
use App\Libraries\MailSender;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\FileCollection;
use CodeIgniter\Files\File;
use CodeIgniter\Shield\Authentication\Actions\EmailActivator;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserIdentityModel;
use App\Modules\Offices\Models\OfficesModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserManagementController extends RegisterController
{
    use ResponseTrait;

    private $userModel;
    private $pager;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function list()
    {
        $perPage = 10;
        $currentUser = auth()->user();

        $filterData = [];

        $users_data =  $this->userModel->getUsersByFilter($filterData, 1, $perPage);

        //var_dump($this->userModel->getLastQuery());

        $pager = \Config\Services::pager();

        $jobTitleModel = new \App\Modules\User\Models\JobTitleModel();
        $jobTitles = $jobTitleModel->getJobTitles($currentUser->company_id);

        $filter_data = $this->getFilterData();

        $search_data = [];
        $search_data['user_by_name_or_email'] = [];

        return view(
            'UserManagement/list',
            [
                'users' => $users_data,
                'pager' => $pager,
                'jobTitles' => $jobTitles,
                'filter_data' => $filter_data,
                'search_data' => $search_data,
                'new_user' => $this->userModel,
                'title' => 'User List',
                'bodyClass' => 'user-management-page minimize_sidenav',
            ]
        );
    }


    public function getFilteredUsers()
    {
        $perPage = 10;

        // Retrieve filter values
        $filters = [
            'status' => $this->request->getVar('status'),
            'role' => $this->request->getVar('role'),
            'user_name_email' => $this->request->getVar('user_name_email'),
            'plaintiff_name' => $this->request->getVar('plaintiff_name'),
            'job_title' => $this->request->getVar('job_title'),
        ];

        $page = $this->request->getVar('page') ?? 1;

        //var_dump($filters); die;

        $users_data =  $this->userModel->getUsersByFilter($filters, $page, $perPage);
        //var_dump($this->userModel->getLastQuery());
        $pager = \Config\Services::pager();

        $Content = view('UserManagement/list_table', [
            'users' => $users_data,
            'pager' => $pager,
            'filters' => $filters,
            'page' => $page,
            'perPage' => $perPage,
            'title' => 'User List',
            'bodyClass' => 'user-management-page minimize_sidenav',
            ]);

        $SectionOffcanvas = view('UserManagement/user_offcanvas', [ 
                'users' => $users_data, 
                ]);
    
            // Pass data to the view
        $data = [
                'Content' => $Content,
                'SectionOffcanvas' => $SectionOffcanvas
        ];

        return $this->response->setJSON($data);
    }

    public function searchUserByNameOrEmail()
    {
        $query = $this->request->getVar('search');

        if (!$query) {
            return $this->fail('Search query is required', 400);
        }

        $user = auth()->user();

        $users_list = $this->userModel->getUsersByNamesOrEmail($query, $user->company_id);
        
        $data = [
            "searchResult" => view('UserManagement/user-search-list', ['users_list' => $users_list])
        ];

        return $this->response->setJSON($data);
    }


    public function getUserData($user_id = false)
    {
        if (!$user_id) {
            $user_id = $this->request->getPost('id');
        }

        $user =  $this->userModel->getUserById($user_id);
        $users = auth()->getProvider();
        $user_single = $users->findById($user_id);

        $data = [
            'success' => true,
            'user' => $user,
            'user_single' => $user_single,
        ];

        return $this->response->setJSON($data);
    }

    public function editUserOffcanvas() {
        $user_id = $this->request->getPost('user_id');
        $user = $this->userModel->find($user_id);

        $jobTitleModel = new \App\Modules\User\Models\JobTitleModel();
        $jobTitles = $jobTitleModel->getJobTitles($user->company_id);

        $data = [
            "offcanvasContent" => view('UserManagement/_edit-user-offcanvas', ['user' => $user, 'select' => $jobTitles, 'offcanvas_wrap' => false])
        ];

        return $this->response->setJSON($data);
    }


    public function userUpdate()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required',
            'role' => 'required|in_list[assignee,manager,admin]',
            'phone_number' => 'required|permit_empty|trim',
            'mobile_number' => 'permit_empty|trim',
            'employee_id' => 'max_length[20]',
            'job_title' => 'required|max_length[50]',
            'office_name' => 'required|max_length[50]'
        ];

        $user_id = (int)$this->request->getPost('user_id');

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $user = $this->userModel->find($user_id);
        if (!$user) {
            return $this->fail("User not found", 400);
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'group' => $this->request->getPost('role'),
            'phone_number' => $this->request->getPost('phone_number'),
            'work_phone_number' => $this->request->getPost('mobile_number'),
            'employee_id' => $this->request->getPost('employee_id'),
            'job_title' => $this->request->getPost('job_title'),
            'office_name' => $this->request->getPost('office_name'),
        ];


        $groups = $user->getGroups();
        if (isset($groups[0]) && $groups[0] != $data['group']) {
            $user->removeGroup($groups[0]);
            $user->addGroup($data['group']);
        }

        if (!$this->userModel->update($user_id, $data)) {
            return $this->failServerError('Failed to update user data');
        }

        $currentUser = auth()->user();
        $domain = $currentUser->getUserCompanyDomain();
        $email = $this->request->getPost('email') . "@" . $domain;

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $builder->where('user_id', $user_id)
            ->where('type', 'email_password')
            ->update(['secret' => $email]);

        $config = config('AuthGroups');
        $user->group_name = $config->groups[$user->groups[0]]['title'];

        return $this->response->setJSON([
            'status' => ResponseInterface::HTTP_OK,
            'message' => 'User updated successfully',
            'canvas' => view('UserManagement/user_offcanvas', ['users' => [$user]])
        ]);
    }


    private function get_post_data()
    {
        $postData = $this->request->getPost();
        $data = [];

        foreach ($postData as $key => $value) {
            if ($value == 'true') $value = 1;
            if ($value == 'false') $value = 0;
            $data[$key] = $value;
        }

        $data['account_last_modified'] = date('Y-m-d H:i:s');

        //var_dump($data); die;

        return $data;
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
            'current_password' => [
                'label' =>  'Auth.currentPassword',
                'rules' => 'required|current_password',
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



    public function deactivateUsers()
    {
        $request = service('request');
        $ids = $request->getPost('ids');

        //var_dump($ids); die;

        if (empty($ids) || !is_array($ids)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No valid user IDs provided.']);
        }

        $userModel = new UserModel();


        foreach ($ids as $id) {
            $user = $userModel->find($id);
            if ($user) {
                $user->active = 0;
                $user->status = 'ban';
                $user->user_status = 'Suspended';
                $user->status_message = 'Suspended';
                $user->last_suspension = date('Y-m-d H:i:s');
                $userModel->save($user);
            }
        }

        return $this->response->setStatusCode(200)->setJSON(['success' => 'Users deactivated successfully.']);
    }


    public function reactivateUsers()
    {
        $request = service('request');
        $ids = $request->getPost('ids');

        
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No valid user IDs provided.']);
        }

        $userModel = new UserModel();

        // Ре-активація користувачів
        foreach ($ids as $id) {
            $user = $userModel->find($id);
            if ($user) {
                $user->active = 1;
                $user->status = '';
                $user->user_status = 'Registered';
                $user->status_message = '';
                $user->last_reactivation = date('Y-m-d H:i:s');
                $userModel->save($user);
            }
        }

        return $this->response->setStatusCode(200)->setJSON(['success' => 'Users reactivated successfully.']);
    }


    public function deleteUsers()
    {
        $request = service('request');
        $ids = $request->getPost('ids');

        if (empty($ids) || !is_array($ids)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No valid user IDs provided.']);
        }

        $userModel = new UserModel();

        foreach ($ids as $id) {
            $user = $userModel->find($id);
            if ($user) {
                $user->active = 2;
                $userModel->save($user);
            }
        }

        return $this->response->setStatusCode(200)->setJSON(['success' => 'Users deleted successfully.']);
    }


    private function getFilterData()
    {
        $filter_data = [];

        $filter_data['plantiff_names'] = $this->userModel->getPlantiffNamesByFilter();

        return $filter_data;
    } 


    public function getLastUsers()
    {
        $perPage = 10;

        // Get the currently authenticated user
        $user = auth()->user();
        if (!$user) {
            return $this->fail('User not authenticated', 401); // Return 401 Unauthorized if no user is logged in
        }

        try {
            $registeredUsers = $this->userModel->getLastUsers('Registered', $perPage);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching registered users: ' . $e->getMessage());
            return $this->fail('Failed to retrieve registered users.', 500);
        }

        try {
            $invitedUsers = $this->userModel->getLastUsers('Invited', $perPage);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching invited users: ' . $e->getMessage());
            return $this->fail('Failed to retrieve invited users.', 500);
        }

        // Return the users in a single response
        return $this->response->setJSON([
            'registeredUsers' => $registeredUsers,
            'invitedUsers' => $invitedUsers,
            'perPage' => $perPage
        ]);
    }


    public function updateUserPhoto($user_id)
    {
        $users = auth()->getProvider();
        $user = $users->findById($user_id);

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


    public function downloadUsersCSV()
    {
        $userModel = new UserModel();; 
        helper('App\Modules\User\Helpers\users');

        // Retrieve filter values
        $filters = [
            'status' => $this->request->getVar('status'),
            'role' => $this->request->getVar('role'),
            'user_name_email' => $this->request->getVar('user_name_email'),
            'plaintiff_name' => $this->request->getVar('plaintiff_name'),
            'job_title' => $this->request->getVar('job_title'),
        ];

        // Fetch users based on filters (assuming a high per-page limit to fetch all filtered results)
        $users = $userModel->getUsersByFilter($filters, 1, 1000); // Adjust perPage if needed

        // Prepare CSV file
        $filename = 'users_report_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Open output stream
        $output = fopen('php://output', 'w');

        // TODO
        //On the .CSV we should include at the very top: Company: The Salameh Law Group 
        //Table Name: Users Date: 06-30-2023 Time: 2:31 PM EST

        // Add CSV header
        fputcsv($output, [
            'Status',
            'Full Name',
            'Email',
            'Phone',
            'Company Name',
            'Office Name',
            'Role',
            'Job Title',
            'Registered On',
            'Last Suspension',
            'Last Reactivation',
            'Last Sign-In',
        ]);

        // Add user data to CSV
        foreach ($users as $user) {
            fputcsv($output, [
                $user->user_status ?? '—',
                $user->first_name . ' ' . $user->last_name,
                $user->email,
                $user->phone_number,
                $user->company_name,
                $user->office_name,
                ucfirst($user->group_name),
                $user->job_title ?? '—',
                !empty($user->registered_on) ? format_date($user->registered_on, 'full') : '—',
                !empty($user->last_suspension) ? format_date($user->last_suspension, 'full') : '—',
                !empty($user->last_reactivation) ? format_date($user->last_reactivation, 'full') : '—',
                !empty($user->last_login) ? format_date($user->last_login, 'full') : '—',
                
            ]);
        }        

        // Close output stream
        fclose($output);
        exit; // Ensure no further output is sent
    }



}
