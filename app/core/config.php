<?php
defined('ROOTPATH') OR exit('Access Denied');

if((empty($_SERVER['SERVER_NAME']) && php_sapi_name() == 'cli') || (!empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost')){
    // database config
    define('DBNAME', 'my_db');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');

define('ROOT','http://localhost/mvc/public');

}else{

        // database config
    define('DBNAME', 'my_db');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');

    define('ROOT','https://my-websie.com');
}


define('APP_NAME', "my Website");
define('APP_DESC', "my Website is an electronic store ");

define('DEBUG', true); // true = debug mode

