<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('transactions', ['namespace' => 'App\Modules\Transactions\Controllers'], function($subroutes){
	
	$subroutes->get('list', 'TransactionController::list');
	$subroutes->add('filter', 'TransactionController::filter');

});
