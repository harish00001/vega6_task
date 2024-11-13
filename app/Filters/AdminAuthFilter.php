<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AdminAuthFilter implements FilterInterface
{

    private $notSessionPage    = array(
        'admin/login',
        'admin/changepassword',
        'admin/logout',
        'admin/refreshcaptcha',
        'admin/auth/loginSubmit'
    );
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('easy_helper');
        $gl = service('gl');
        $request = \Config\Services::request();
        $session = Services::session();
        $AdminModel     = model('App\Models\AdminModel', false);
        $route    = uri_string();
        $gl::pr(  $route,1);
        if (!in_array($route, $this->notSessionPage)) {
            if (!session()->get('USER_LOGGED_IN')) {
                header("Location: login");
                exit();
            }
        }else{
            is_authenticated($session, $AdminModel);
            

        }
    
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after request
    }
}
