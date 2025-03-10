<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

// Admin
$routes->group('user', ['namespace' => 'App\Modules\User\Controllers'], function($subroutes){

	/*** Route for AdminUserController ***/
	$subroutes->add('list', 'AdminUserController::list');
	$subroutes->get('edit-profile', 'AdminUserController::editProfileView');
	$subroutes->get('edit-profile/(:num)', 'AdminUserController::editProfileByIdView/$1');
	$subroutes->post('delete-profile', 'AdminUserController::deleteProfileById');
	$subroutes->post('edit-profile', 'AdminUserController::profileSave');
	$subroutes->post('update-avatar/(:num)', 'AdminUserController::updateUserAvatar/$1');
	
	$subroutes->get('profile-avatar', 'AdminUserController::getUserAvatar', ['as' => 'user_avatar']);
	$subroutes->get('profile-avatar/(:num)', 'AdminUserController::getUserAvatar/$1');

	$subroutes->get('list', 'AdminUserController::list', ['as' => 'user_list']);
	$subroutes->get('invite', 'AdminUserController::invite');
	$subroutes->post('create-profile', 'AdminUserController::createProfile');

});


// Front Flow
$routes->group('accounts', ['namespace' => 'App\Modules\User\Controllers'], function($subroutes){

	$subroutes->post('registration', 'RegisterController::registerAction', ['as'=> 'registration']);
	$subroutes->get('approve/(:any)/(:num)', 'RegisterController::emailApprove/$1/$2');
	$subroutes->get('add-phone', 'RegisterController::addPhone', ['as'=>'add-phone']);
	$subroutes->post('set-phone', 'RegisterController::setPhone', ['as'=>'set-phone']);
	$subroutes->get('confirm-2fa', 'RegisterController::confirm2FA', ['as'=>'confirm-2fa']);
	$subroutes->post('check-2fa', 'RegisterController::check2FA', ['as'=>'check-2fa']);
	$subroutes->post('resend-2fa-code', 'RegisterController::resend2FACode', ['as'=>'resend-2fa-code']);
	
	$subroutes->get('new-password', 'RegisterController::newPassword', ['as'=>'new-password']);
	$subroutes->get('new-password/reset', 'RegisterController::newPassword/reset', ['as'=>'new-password/reset']);
	$subroutes->post('set-password', 'RegisterController::setNewPassword', ['as'=>'set-password']);
	$subroutes->get('reset-password', 'RegisterController::resetPassword', ['as'=> 'reset-password']);
	$subroutes->post('reset-password', 'RegisterController::processResetPassword', ['as'=>'post-reset-password']);
	$subroutes->get('set-new-password', 'RegisterController::setNewResetPassword', ['as'=>'set-new-password']);
	$subroutes->get('password-changed', 'RegisterController::passwordChanged', ['as'=>'password-changed']);
	
	$subroutes->get('account-details', 'RegisterController::accountDetailsForm', ['as'=>'account-details']);
	$subroutes->post('save-account-details', 'RegisterController::accountDetailsSave', ['as'=>'save-account-details']);

	$subroutes->post('login', 'RegisterController::registerAction', ['as'=> 'login']);

	$subroutes->post('invite-users', 'AccountController::inviteUsersSave', ['as'=> 'invite-users']);
	$subroutes->get('onboarding/(:any)', 'RegisterController::UserOnboarding/$1', ['as'=>'onboarding']);
	$subroutes->get('onboarding-confirm', 'RegisterController::UserOnboardingConfirm', ['as'=>'onboarding-confirm']);
	$subroutes->post('onboarding-confirm', 'RegisterController::processUserOnboardingConfirm', ['as'=>'set-onboarding-confirm']);
	$subroutes->get('approval/(:any)/(:any)', 'RegisterController::Approval', ['as'=>'approval']);
	$subroutes->get('invite-new-password', 'RegisterController::inviteNewPassword', ['as'=>'invite-new-password']);
	
	$subroutes->get('invite-add-phone', 'RegisterController::inviteAddPhone', ['as'=>'invite-add-phone']);
	

});



$routes->group('account', ['namespace' => 'App\Modules\User\Controllers'], function($subroutes){

	
	$subroutes->get('profile', 'AccountController::editProfileView');
	$subroutes->post('profile', 'AccountController::profileSave');
	
	$subroutes->get('notifications', 'AccountController::notifications');
	$subroutes->get('notifications/filter', 'AccountController::notificationsFilter');
	$subroutes->get('notifications/filter/(:any)', 'AccountController::notificationsFilter/$1');
	
	
	$subroutes->post('updatepass', 'AccountController::profilePasswordUpdate');
	$subroutes->post('update-photo', 'AccountController::updateUserPhoto');
	
	

});


$routes->group('user-management', ['namespace' => 'App\Modules\User\Controllers'], function($subroutes){
	
	$subroutes->get('list', 'UserManagementController::list');
	$subroutes->add('list/filter', 'UserManagementController::getFilteredUsers');

	$subroutes->get('get-last-users', 'UserManagementController::getLastUsers');

	$subroutes->get('edit-profile/(:num)', 'UserManagementController::editProfileView/$1');

	$subroutes->add('download_csv', 'UserManagementController::downloadUsersCSV'); 
	
	//$subroutes->post('get-user-data', 'UserManagementController::getUserData');
	$subroutes->post('user-update', 'UserManagementController::userUpdate', ['as' => 'user-update']);
	//$subroutes->post('user-update-preferences', 'UserManagementController::userUpdatePreferences', ['as' => 'user-update-preferences']);
	
	$subroutes->post('edit-user-offcanvas', 'UserManagementController::editUserOffcanvas');

	$subroutes->post('deactivate-users', 'UserManagementController::deactivateUsers');
	$subroutes->post('reactivate-users', 'UserManagementController::reactivateUsers');
	$subroutes->post('delete-users', 'UserManagementController::deleteUsers');
	$subroutes->get('search', 'UserManagementController::getSearchUsers');

	$subroutes->add('search-user', 'UserManagementController::searchUserByNameOrEmail');
});


$routes->group('job-title', ['namespace' => 'App\Modules\User\Controllers'], function($subroutes){
	
	    // List job titles (global + company-specific)
		$subroutes->add('list', 'JobTitleController::list');
    
		// Add a new job title (POST request)
		$subroutes->post('add', 'JobTitleController::add');
		
		// Update an existing job title (POST request)
		$subroutes->post('update/(:num)', 'JobTitleController::update/$1');
		
		// Delete a job title (POST or DELETE request)
		$subroutes->post('delete/(:num)', 'JobTitleController::delete/$1');
});