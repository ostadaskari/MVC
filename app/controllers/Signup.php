<?php

namespace Controller;

use Model\User;

class Signup
{
    use \Controller;


    public function index()
    {
        $req = new \Model\Request;

        $data['user'] = new User();

        if ($req->posted()) {
            $data['user']->signup($_POST);
        }

        $this->view('signup', $data);
    }

}