<?php
if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

//Multi-language functionality 
$routes->get('/lang/(:segment)', '\App\Modules\Language\Controllers\LanguageController::set/$1');
