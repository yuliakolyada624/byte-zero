<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('countries', ['namespace' => 'App\Modules\Countries\Controllers'], function($subroutes){

	$subroutes->add('list', 'CountriesController::index');
	$subroutes->get('edit/(:num)', 'CountriesController::edit/$1');
	$subroutes->post('update', 'CountriesController::update');

});