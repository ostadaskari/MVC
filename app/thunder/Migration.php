<?php

namespace Thunder;

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

    protected function createTable($table)
    {
        if (!empty($this->columns)) {
            $query= "CREATE TABLE IF NOT EXISTS $table (";
            foreach ($this->columns as $column){
                $query .= $column . ",";
            }
            foreach ($this->primaryKeys as $key){
                $query .= "PRIMARY KEY (".$key. "),";
            }
            foreach ($this->uniqueKeys as $key){
                $query .= "UNIQUE KEY (".$key. "),";
            }
            foreach ($this->keys as $key){
                $query .= "KEY (".$key. "),";
            }
            $query = trim($query, ",");
            $query .= " ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $this->query($query);

            $this->columns          = [];
            $this->keys             = [];
            $this->primaryKeys      = [];
            $this->uniqueKeys       = [];

            echo "\n\r Table $table successfully created!! \n\r";
        }else{
            echo "\n\r Table $table could not be created!  \n\r";
        }
    }
    protected function addColumn($text)
    {
        $this->columns[] = $text;
    }
    protected function addPrimaryKey($key)
    {
        $this->primaryKeys[] = $key;
    }
    protected function addUniqueKey($key)
    {
        $this->uniqueKeys[] = $key;
    }
    protected function addData($key,$value)
    {
        $this->data[$key] = $value;
    }

    protected function dropTable($table)
    {
        $this->query("DROP TABLE IF EXISTS ". $table);

        echo "\n\r Table  $table  successfully removed!! \n\r";
    }

    protected function insertData($table)
    {
        if (!empty($this->data)){
            $keys = array_keys($this->data);
            $query= "INSERT INTO $table (" . implode(",",$keys) . ") VALUES (:" . implode(",:",$keys) . ")";
            $this->query($query, $this->data);
            $this->data = [];
            echo "\n\r Data successfully inserted in Table:  $table  !! \n\r";
        }else{
            echo "\n\r Data could not be inserted in Table:  $table !! \n\r";
        }


    }


}