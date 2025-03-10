<?php namespace App\Modules\Language\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class LanguageController extends BaseController
{
    
    // Set application wide locale
    public function set( string $locale )
    {
            session()->set('_ci_previous_url', Services::request()->getServer('HTTP_REFERER', FILTER_SANITIZE_URL));

            // Check requested language exist in \Config\App
            if ( in_array($locale, config('App')->supportedLocales) )
            {
                // Save requested locale in session, will be set by filter
                session()->set('locale', $locale);

                helper('cookie');
                set_cookie( 'lang', $locale);

                // Reload page
                return redirect()->back();
            }
            else
            {
                throw new \CodeIgniter\Exceptions\PageNotFoundException( esc($locale) ." is not a supported language" );
            }
    }


    // Used for lang with url prefix

	/*public function index()
	{
        $user_lang = get_language();

        $session = session();
        helper('cookie');

        $locale = service('request')->getLocale(); 
        set_cookie( 'lang', $locale);
       
        $session->set('_ci_previous_url', Services::request()->getServer('HTTP_REFERER', FILTER_SANITIZE_URL));
        
        $url = Services::request()->getServer('HTTP_REFERER', FILTER_SANITIZE_URL);

       // $session->set('language', $locale);
        
      //  $this->request->setLocale($locale);

       // $language = \Config\Services::language();
       // $language->setLocale($locale); 
        

        
        if(strpos($url, '/'.$user_lang)!==false){
            //replase lang prefix /ru -> /de
            $url = str_replace('/'.$user_lang, '/'.$locale, $url);
        } else {
            // /en to / and replase lang prefix
            $url = $locale=='en' ? '/' : '/'.$locale.'/'. str_replace(base_url(), '', $url);
        }

        // Fix prefix for en (/en to /)
        if(strpos($url, '/en')!==false){
            $url = (strlen($url)==3 ? '/' : str_replace('/en', '', $url) );
        }
       
        // dd($url);
        return redirect()->to($url)->withCookies();

    }*/

}
