<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('currencies', ['namespace' => 'App\Modules\Currencies\Controllers'], function($subroutes){

	$subroutes->add('list', 'CurrenciesController::index');
	$subroutes->get('edit/(:num)', 'CurrenciesController::edit/$1');
	$subroutes->post('update', 'CurrenciesController::update');
	$subroutes->get('update_rates', 'CurrenciesController::update_rates');
	$subroutes->get('set/(:any)', 'CurrenciesController::set/$1');

});