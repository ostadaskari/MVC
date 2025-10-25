<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied');
use \Model\User;
/**
 * logout class
 */
class Logout

{
    use \Controller;
    public function index(){
         $ses = new \Model\Session();
        $ses->logout();
        redirect('login');
    }

}

