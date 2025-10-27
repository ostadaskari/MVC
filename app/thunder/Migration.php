<?php

namespace Migration;

defined('CPATH') OR exit('Access Denied ');

/**
 * Migration class
 */

class Migration
{
    use \Core\Database;

    protected $columns          = [];
    protected $keys             = [];
    protected $primaryKeys      = [];
    protected $uniqueKeys       = [];
    protected $data             = [];

    protected function createTable($table){
        $query= "CREATE TABLE IF NOT EXISTS $table (";
        foreach ($this->columns as $column){
            $query.= $column . ",";
        }
        foreach ($this->primaryKeys as $key){
            $query.= "PRIMARY KEY (".$key. "),";
        }
        foreach ($this->uniqueKeys as $key){
            $query.= "UNIQUE KEY (".$key. "),";
        }
        foreach ($this->keys as $key){
            $query.= "KEY (".$key. "),";
        }
        $this->query($query);
        echo "\n\r Table  $table  successfully created!! \n\r";
    }
    protected function addColumn($text){
        $this->columns[] = $text;
    }
    protected function addPrimaryKey($key){
        $this->primaryKeys[] = $key;
    }
    protected function addUniqueKey($key){
        $this->uniqueKeys[] = $key;
    }
    protected function addData($key,$value){
        $this->data[$key] = $value;
    }

    protected function dropTable($table){
        $this->query("DROP TABLE IF EXISTS". $table);
        echo "\n\r Table  $table  successfully removed!! \n\r";
    }


CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`email` varchar(100) NOT NULL,
`username` varchar(100) DEFAULT NULL,
`password` varchar(255) NOT NULL,
`date` datetime NOT NULL DEFAULT current_timestamp(),
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

}