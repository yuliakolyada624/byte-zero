<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Lang implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //dd(session()->has('locale'));
        if (session()->has('locale'))
        {
            // Set site language to session locale value
            service('language')->setLocale(session('locale'));
        }
        else
        {
            // Save locale to session
            session()->set('locale', service('language')->getLocale());
        }
        /*
        $uri = $request->uri;
        $segments = array_filter($uri->getSegments());
        $nbSegments = count($segments);

        // Keep only the first 2 letters (en-UK => en)
        $userLocale = strtolower(substr($request->getLocale(), 0, 2));
        log_message('debug', "FilterLocalize - Visitor's locale $userLocale");
        
        
        // If the user's language is not a supported language, take the default language
        $locale = in_array($userLocale, $request->config->supportedLocales) ? $userLocale : $request->config->defaultLocale;
        log_message('debug', "FilterLocalize - Selected locale $locale");
     

        helper('cookie');

        $language = get_cookie('lang');
        */
        // exist set in cookie
      /*  if($language && $language!=$locale){
            set_cookie( 'lang', $locale);
            $url = Services::request()->getServer('HTTP_REFERER', FILTER_SANITIZE_URL);
            //d($language);
            d($userLocale);
            d($locale);
            d($url);
            $url = str_replace($userLocale, $locale, $url);
            dd($url);
            
            //$url = $url ? $url : '/'.$locale;
            return redirect()->to($url)->withCookies();
        }*/
        
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}


