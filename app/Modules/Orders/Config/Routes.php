<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('orders', ['namespace' => 'App\Modules\Orders\Controllers'], function($subroutes){
	// Front
	$subroutes->add('cases', 'OrdersController::cases'); 
	$subroutes->add('cases/filter', 'OrdersController::casesFilter'); 
	$subroutes->add('cases/get-names', 'OrdersController::getPlaintiffDefendantNames');


	//medical-chronology-request
	$subroutes->add('medical-chronology-request', 'OrdersController::medicalChronologyRequest', ['as'=>'medical-chronology-request']); 
	$subroutes->post('save-medical-chronology-request', 'OrdersController::saveMedicalChronologyRequest', ['as'=>'save-medical-chronology-request']); 
	$subroutes->post('upload-exhibits', 'OrdersController::uploadExhibits', ['as'=>'upload-exhibits']); 
	$subroutes->post('delete-exhibit', 'OrdersController::deleteExhibit');
	
	$subroutes->get('medical-chronology-review/(:any)', 'OrdersController::reviewMedicalChronologyOrder/$1'); 

	

});


