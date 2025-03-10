<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('landing', ['namespace' => 'App\Modules\Landing\Controllers'], function($subroutes){

	/*** Route for Home ***/
	$subroutes->add('home', 'Home::index');
	$subroutes->add('send-form', 'Home::sendForm');

});