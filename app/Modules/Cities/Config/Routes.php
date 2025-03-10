<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('cities', ['namespace' => 'App\Modules\Cities\Controllers'], function($subroutes){

	$subroutes->add('list', 'CitiesController::index');
	$subroutes->get('edit/(:num)', 'CitiesController::edit/$1');
	$subroutes->post('update', 'CitiesController::update');
	$subroutes->get('import', 'CitiesController::import');
	$subroutes->add('set_filters', 'CitiesController::setFilters');
	$subroutes->add('add_poi_task/(:num)', 'CitiesController::addPOITask/$1');

});