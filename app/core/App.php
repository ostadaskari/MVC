<?php
defined('ROOTPATH') OR exit('Access Denied');

class App
{
private $controller = 'home';
private $method = 'index'; 

private function splitURL(){
    $url= $_GET['url'] ?? 'home';
    $url= explode("/", trim($url,"/"));
    return $url;
}
 public function loadController(){
    $url = $this->splitURL();

        /* select controller */
    $filename = "../app/controllers/".ucfirst($url[0]).".php";
    if(file_exists($filename)){
       require $filename; 
       $this->controller = ucfirst($url[0]);
       unset($url[0]);
    }else{
        $filename = "../app/controllers/_404.php";
       require $filename;
       $this->controller = "_404";
    }

    $className = '\\Controller\\' . $this->controller;
    $controller = new $className();

    /* select method */
    if(!empty($url[1])){
        if(method_exists($controller, $url[1] )){
            $this->method = $url[1];
            unset($url[1]);
        }
    }
    
    call_user_func_array([$controller,$this->method], $url);
}
}
