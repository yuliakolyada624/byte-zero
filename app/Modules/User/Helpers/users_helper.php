<?php

/*
    helper('App\Modules\User\Helpers\users');
*/

function getTotalUserInOffice($office_id){
    
    $userModel = new App\Modules\User\Models\UserModel();
    return $userModel->where('office_id', $office_id)->countAllResults();
}

function getTotalRegisteredUserInOffice($office_id){
    $userModel = new App\Modules\User\Models\UserModel();
    return $userModel->where('office_id', $office_id)->where('active', '1')->countAllResults();
}

function getTotalInvitedUserInOffice($office_id){
    $userModel = new App\Modules\User\Models\UserModel();
    return $userModel->where('office_id', $office_id)->where('active', '0')->countAllResults();
}



function get_user_full_name($user_id){
    $userModel = new App\Modules\User\Models\UserModel();
    $user =  $userModel->find($user_id);
    if(!$user){
        return 'not found';
    }
    return $user->first_name .' '. $user->last_name;
}



if (!function_exists('get_user_details')) {
    function get_user_details($user_id) {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        
        $builder->select('users.*, auth_identities.secret as email,
                         auth_groups_users.group as user_group')
                ->join('auth_groups_users', 'users.id = auth_groups_users.user_id')
                ->join('auth_identities', 'users.id = auth_identities.user_id')
                
                ->where('users.id', $user_id)
                ->where('auth_identities.type', 'email_password');
        
        $query = $builder->get();
        $user = $query->getRowArray();

        //var_dump($user); die;
    
        if (!$user) {
            return 'User not found';
        }
    
        $config = config('AuthGroups');
    
        if (isset($config->groups[$user['user_group']])) {
            $user['group_name'] = $config->groups[$user['user_group']]['title'];
        } else {
            $user['group_name'] = $user['user_group'];
        }

        $user['full_name']  = $user['first_name']. ' '. $user['last_name'];
    
        return $user;
    }
}