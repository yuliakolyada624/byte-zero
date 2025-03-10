<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('companies', ['namespace' => 'App\Modules\Companies\Controllers'], function($subroutes){

	$subroutes->add('list', 'CompaniesController::index');
	$subroutes->get('edit/(:num)', 'CompaniesController::edit/$1');
	$subroutes->post('update', 'CompaniesController::update');
	$subroutes->get('create', 'CompaniesController::create');
	$subroutes->post('delete', 'CompaniesController::delete');

	/* Front */
	$subroutes->get('companies-list', 'CompaniesController::companiesList');
	$subroutes->get('company-create', 'CompaniesController::companyCreate');
	$subroutes->get('company-edit/(:num)', 'CompaniesController::companyEdit/$1');

	// in use
	$subroutes->get('sign-up-company', 'CompaniesController::signUpCompany', ['as'=>'sign-up-company']);
	$subroutes->get('get-company/(:num)', 'CompaniesController::getCompany/$1', ['as'=> 'get-company']);
	$subroutes->post('company-create', 'CompaniesController::companySave', ['as'=> 'company-create']);
	$subroutes->post('company-update', 'CompaniesController::companyUpdate', ['as'=> 'company-update']);
});
