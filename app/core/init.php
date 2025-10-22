<?php
defined('ROOTPATH') OR exit('Access Denied');

//autoload for calling models
spl_autoload_register(function($classname){
    $classname = explode('\\', $classname);
    $classname = array_pop($classname);
    require $filename = "../app/models/".ucfirst($classname).".php";
});
require_once 'config.php';
require_once 'functions.php';
require_once 'Database.php';
require_once 'Model.php';
require_once 'Controller.php';
require_once 'App.php';