<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;
use Config\View as ViewConfig;

use App\Libraries\Pager\FrontPager;
use Config\Services as AppServices;
use Config\Pager as PagerConfig;


require_once SYSTEMPATH . 'Config/Services.php';

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{

	//    public static function example($getShared = true)
	//    {
	//        if ($getShared)
	//        {
	//            return static::getSharedInstance('example');
	//        }
	//
	//        return new \CodeIgniter\Example();
	//    }

	public static function renderer(?string $viewPath = APPPATH . 'views/', ?ViewConfig $config = null, bool $getShared = true)
    {
		
		$config = config('View');
		$app_config = config('App');
		$viewPath = APPPATH . 'Views/'.$app_config->theme.'/';
		//d($viewPath);
        //return new \CodeIgniter\View\View($config, $viewPath);
		return new \App\Libraries\View($config, $viewPath);
    }


	public static function front_pager(?PagerConfig $config = null, ?RendererInterface $view = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('front_pager', $config, $view);
        }
		//dd('111');

        $config ??= config(PagerConfig::class);
        $view ??= AppServices::renderer(null, null, false);

        return new FrontPager($config, $view);
    }


	public static function aws($getShared = true)
	{
		if ($getShared) {
		return static::getSharedInstance('aws');
		}

		$config = config('AWS');
		
		$credentials = new \Aws\Credentials\Credentials($config->accessKey, $config->secretKey);

		$sdk = new \Aws\Sdk([
			'credentials' => $credentials,
			'region' => $config->region,
			//'debug'  => true,
		]);

		return $sdk;
	}



}
