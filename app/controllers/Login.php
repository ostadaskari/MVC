<?php

namespace Controller;

use Model\User;

class Login
{
    use \Controller;


    public function index()
    {
        $req = new \Model\Request;

        $data['user'] = new User();

        if($req->posted()){
            $data['user']->login($_POST);
        }

        $this->view('login',$data);
    }

}