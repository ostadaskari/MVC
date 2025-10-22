<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied');

class _404 
{
    use Controller;
    public function index($a ='',$b ='',$c =''){
       echo "404 controller!!!!"; 
    }
}
