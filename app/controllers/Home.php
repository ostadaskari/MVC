<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied');

use \Model\User;
class Home 

{
    use \Controller;
    public function index(){

       $this->view('home');
    }

    // public function edit($a ='',$b ='',$c =''){
    //   show('from edit method');
    //    $this->view('home');
    // }
}

