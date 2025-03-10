<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = auth()->user();
         //dd($user);
 
         if (is_null($user)) {
            //dd(config('Auth')->logoutRedirect());
            return redirect()->to(config('Auth')->logoutRedirect())->with('message', lang('Auth.successLogout'));
         } 

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
