<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('streamer', ['namespace' => 'App\Modules\Notifications\Controllers'], function($subroutes){

	$subroutes->add('get', 'Controller::index');
	$subroutes->add('streamer', 'Controller::index');

});

$routes->group('notification', ['namespace' => 'App\Modules\Notifications\Controllers'], function($subroutes){

	$subroutes->add('update', 'NotificationController::update');
	$subroutes->add('delete', 'NotificationController::delete');
	$subroutes->add('delete-forever', 'NotificationController::deleteForever');

});