<?php 
namespace App\Modules\User\Models;

use CodeIgniter\Shield\Models\UserModel as ModelsUserModel;
use App\Modules\User\Entities\UserEntitie as User;

class UserModel extends ModelsUserModel
{
    protected $returnType     = User::class;

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    
    protected function initialize(): void
    {
        parent::initialize();
    
        //$this->table = $this->tables['users'];
    
    
        // Merge properties with parent
        $this->allowedFields = array_merge($this->allowedFields, [
            'first_name',
            //'middle_name',
            'last_name',
            'phone_number',
            'phone_number_code',
            'phone_number_country',
            'work_phone_number_code',
            'work_phone_number_country',
            'work_phone_number',
            'avatar',
            'company_id',
            'office_name',
            'country', 
            'country_a2code', 
            'city',
            'address_line_1',
            'address_line_2',
            'district',
            'zip_code',
            'sms_code',
            'sms_expires_at',
            'user_status',
            'job_title',
            'employee_id',
            'last_login',
            'last_active',
            'last_updated',
            'registered_on',
            'last_password_update',
            'last_suspension',
            'last_reactivation',
            'password_change_frequency',
            'permanently_delete_notifications_older_than',
            /* checked 30-11-2024 by Alex */
        ]);
    }


    public function get_countries_list(){
    	return $this->db->query("SELECT * FROM countries where active=1  ORDER BY `name_english` ASC")->getResult();
    }


    public function get_currencies_list(){
    	return $this->db->query("SELECT * FROM currencies where is_active='Yes'")->getResult();
    }


    public function get_companies_list(){
    	return $this->db->query("SELECT * FROM companies")->getResult();
    }

    public function get_states_list(){
    	return $this->db->query("SELECT * FROM regions where country='US' order by `name_en` ASC")->getResult();
    }

    public function get_provinces_list(){
    	return $this->db->query("SELECT * FROM regions where country='CA' order by `name_en` ASC")->getResult();
    }

    public function getUsersByGroup($group = 'superadmin'){
        return $this->db->query("SELECT users.*
                                FROM users
                                LEFT JOIN auth_groups_users ON users.id = auth_groups_users.user_id
                                WHERE users.active = 1 AND auth_groups_users.group = '$group'
                                ")
                            ->getResult();  
    }



    public function getUsersByCompanyId($status = '1', $company_id=null, $limit=500){
        $query = "SELECT users.*, auth_groups_users.group, departments.name as department,
                    offices.office_title, offices.country as office_country, 
                    auth_identities.secret as email 
                    FROM users
                    LEFT JOIN auth_groups_users ON users.id = auth_groups_users.user_id 
                    LEFT JOIN departments ON users.department_id = departments.id 
                    LEFT JOIN offices ON users.office_id = offices.id 
                    LEFT JOIN auth_identities ON users.id = auth_identities.user_id 
                    WHERE users.active = '$status' 
                    AND auth_identities.type = 'email_password'
                    ";
                if($company_id){
                    $query .= " AND users.company_id = '$company_id'";
                }
                $query .= " limit $limit";
                    
        $users = $this->db->query($query)->getResult();

        $config = config('AuthGroups');

        // We sort users and set the name of the group
        foreach ($users as $user) {
            if (isset($config->groups[$user->group])) {
                $user->group_name = $config->groups[$user->group]['title'];
            } else {
                $user->group_name = $user->group;
            }

        }

        return $users;
    }

    public function getUsersByIds($user_ids, $status = '1'){
        if(!$user_ids){
            return null;
        }

        $query = "SELECT users.*, auth_groups_users.group, departments.name as department,
                    offices.office_title, offices.country as office_country, 
                    auth_identities.secret as email 
                    FROM users
                    LEFT JOIN auth_groups_users ON users.id = auth_groups_users.user_id 
                    LEFT JOIN departments ON users.department_id = departments.id 
                    LEFT JOIN offices ON users.office_id = offices.id 
                    LEFT JOIN auth_identities ON users.id = auth_identities.user_id 
                    WHERE users.active = '$status' 
                    AND auth_identities.type = 'email_password'
                    ";
                if(is_array($user_ids))
                    $query .= " AND users.id in (".implode(',', $user_ids).")";
                else
                    $query .= " AND users.id = $user_ids";
                    
        $users = $this->db->query($query)->getResult();

        $config = config('AuthGroups');

        // We sort users and set the name of the group
        foreach ($users as $user) {
            if (isset($config->groups[$user->group])) {
                $user->group_name = $config->groups[$user->group]['title'];
            } else {
                $user->group_name = $user->group;
            }

        }

        return $users;
    }


    public function getUserById($user_id){
        if(!$user_id){
            return null;
        }

        $builder = $this->db->table('users')
                    ->select('users.*, auth_groups_users.group, companies.company_name, auth_identities.secret as email')
                    ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
                    ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
                    ->join('companies', 'users.company_id = companies.id', 'left') 
                    ->where('auth_identities.type', 'email_password')
                    ->where('users.id', $user_id);

        $user = $builder->get()->getRow();
        //  dd($user);
        //var_dump($user); die;
        
        $config = config('AuthGroups');

            if (isset($config->groups[$user->group])) {
                $user->group_name = $config->groups[$user->group]['title'];
            } else {
                $user->group_name = $user->group;
            }


        return $user;
    }



    public function getUsersByFilter($filters = [], $page = 1, $perPage = 10)
    {
        // Get the authenticated user's company ID
        $user = auth()->user();

        // Start building the query
        $builder = $this->select('users.*, auth_groups_users.group, auth_identities.secret as email')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
            ->where('auth_identities.type', 'email_password')
            ->where('users.company_id', $user->company_id);

        // Apply filters if provided
        if (!empty($filters['status']) && $filters['status'] != 'all') {
            $builder->where('users.user_status', $filters['status']);
        }

        if (!empty($filters['role']) && $filters['role'] != '' && $filters['role'] != 'Role') {
            $builder->where('auth_groups_users.group', $filters['role']);
        }

        if (!empty($filters['plaintiff_name'])) {
            $builder->where('users.id', (int)$filters['plaintiff_name']);
        }

        if (!empty($filters['job_title'])) {
            if ($filters['job_title'] == "other") {
                $job_title_model = new JobTitleModel();
                $job_title_sub_query = $job_title_model->builder()->select('job_title')->where('company_id', 0)->getCompiledSelect();
                $whereString = "users.job_title NOT IN ($job_title_sub_query)";
                $builder->where($whereString, null, false);
            } else {
                $builder->where('users.job_title', $filters['job_title']);
            }   
        }

        if (!empty($filters['user_name_email']) && $filters['user_name_email'] != '') {
            $builder->where('users.id', (int)$filters['user_name_email']);
        }

        // Get paginated results
        $users = $builder->paginate($perPage, 'default', $page);

        // Get the AuthGroups configuration
        $config = config('AuthGroups');

        // Loop through the users and set the group name based on the config
        foreach ($users as $user) {
            if (isset($config->groups[$user->group])) {
                $user->group_name = $config->groups[$user->group]['title'];
            } else {
                $user->group_name = $user->group;
            }
        }

        return $users;
    }

    public function getPlantiffNamesByFilter() {
         // Get the authenticated user's company ID
        $user = auth()->user();

        // Start building the query
        $names = $this->select('users.*, orders.plaintiff_first_name, orders.plaintiff_last_name')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
            ->join('orders', 'users.id = orders.creater_user_id', 'inner')
            ->where('auth_identities.type', 'email_password')
            ->where('users.company_id', $user->company_id)
            ->get()
            ->getResult();

        return $names;
    }


    public function getLastUsers($status, $perPage = 10)
    {
        // Get the authenticated user's company ID
        $user = auth()->user();

        // Start building the query
        $builder = $this->select('users.*, auth_groups_users.group, auth_identities.secret as email, companies.company_name')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
            ->join('companies', 'users.company_id = companies.id', 'left')
            ->where('auth_identities.type', 'email_password')
            ->where('users.user_status', $status)
            ->where('users.company_id', $user->company_id)
            ->orderBy('users.id', 'desc')
            ->orderBy('users.updated_at', 'desc');

        // Get paginated results
        $users = $builder->paginate($perPage, 'default', 1);

        // Get the AuthGroups configuration
        $config = config('AuthGroups');

        // Loop through the users and set the group name based on the config
        foreach ($users as $user) {
            if (isset($config->groups[$user->group])) {
                $user->group_name = $config->groups[$user->group]['title'];
            } else {
                $user->group_name = $user->group;
            }
        }

        return $users;
    }

    public function getUsersByNamesOrEmail($searchValue, $companyId = null)
    {
        $builder = $this->db->table('users')
            ->select('users.*, auth_identities.secret as email, companies.company_name as company_name_full')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
            ->join('companies', 'users.company_id = companies.id', 'left')
            ->where('auth_identities.type', 'email_password');

        if ($companyId !== null) {
            $builder->where('users.company_id', $companyId);
        }

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('users.first_name', $searchValue)
                ->orLike('users.last_name', $searchValue)
                ->orLike('users.employee_id', $searchValue)
                ->orLike('auth_identities.secret', $searchValue)
                ->orLike('CONCAT(users.first_name, " ", users.last_name)', $searchValue)
            ->groupEnd();
        }

        $users = $builder->get()->getResult($this->returnType);

        return $users;
    }


    public function getUsersBySearchValue($searchValue, $companyId = null, $limit = 50)
    {
        $builder = $this->db->table('users')
            ->select('users.*, auth_groups_users.group, auth_identities.secret as email ')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')
            // ->join('departments', 'users.department_id = departments.id', 'left')
            // ->join('offices', 'users.office_id = offices.id', 'left')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'left')
          //  ->where('users.active', $status)
            ->where('auth_identities.type', 'email_password');

        if ($companyId !== null) {
            $builder->where('users.company_id', $companyId);
        }
        //var_dump($searchValue); die;

        if (!empty($searchValue)) {
            $builder->groupStart()
                    ->like('users.username', $searchValue)
                    ->orLike('users.id', $searchValue)
                    ->orLike('users.first_name', $searchValue)
                    ->orLike('users.last_name', $searchValue)
                    ->orLike('auth_identities.secret', $searchValue)
                    // ->orLike('departments.name', $searchValue)
                    // ->orLike('offices.office_title', $searchValue)
                    ->orLike('CONCAT(users.first_name, " ", users.last_name)', $searchValue)
                    ->groupEnd();
        }

        $builder->limit($limit);

        $users = $builder->get()->getResult($this->returnType);

        $lastQuery = $this->db->getLastQuery();
       // var_dump($lastQuery); die;
        // log_message('debug', 'Last executed query: ' . $lastQuery);

        $config = config('AuthGroups');

        // We sort users and set the name of the group
        foreach ($users as $user) {
            if (isset($config->groups[$user->group])) {
                $user->group_name = $config->groups[$user->group]['title'];
            } else {
                $user->group_name = $user->group;
            }
        }

        return $users;
    }

}