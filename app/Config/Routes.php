<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Modules\Landing\Controllers');

$routes->get('/', 'Home::index');

$routes->group('accounts', static function($routes) {
    service('auth')->routes($routes);
});

// $routes->group('oauth', ['namespace' => '\Datamweb\ShieldOAuth\Controllers'], static function ($routes): void {
//     /** @var ShieldOAuth $shieldOAuthLib */
//     $shieldOAuthLib = service('ShieldOAuth');

//     $routes->addPlaceholder('allOAuthList', $shieldOAuthLib->allOAuth());
//     $routes->get('(:allOAuthList)', 'OAuthController::redirectOAuth/$1');

//     /** @var ShieldOAuthConfig $config */
//     $config = config('ShieldOAuthConfig');

//     $routes->get($config->call_back_route, 'OAuthController::callBack');
// });

/**
 * --------------------------------------------------------------------
 * HMVC Routing
 * --------------------------------------------------------------------
 */

 foreach(glob(APPPATH . 'Modules/*', GLOB_ONLYDIR) as $item_dir)
 {
     if (file_exists($item_dir . '/Config/Routes.php'))
     {
         require_once($item_dir . '/Config/Routes.php');
     }	
 }
 
