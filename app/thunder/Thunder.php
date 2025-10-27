<?php

namespace Thunder;


defined('CPATH') OR exit('No direct script access allowed');

/**
 * thunder class
 */
class Thunder
{
    private $version = '1.0.0';
    public function db($argv)
    {
        $mode       = $argv[1] ?? null;
        $param1     = $argv[2] ?? null;




        switch($mode) {
            case 'db:create':
                /** check if param1 is empty */
                if (empty($param1)) {
                    die("\n\rplease provide a database name\n\r");
                }

                $db = new Database;
                $query = "create database if not exists ".$param1;
                $db->query($query);
                break;


            case 'db:table':
                /** check if param1 is empty */
                if (empty($param1)) {
                    die("\n\rplease provide a table name\n\r");
                }

                $db = new Database;
                $query = "describe ".$param1;
                $res = $db->query($query);
                if ($res) {
                    print_r($res);
                }
                else{
                    echo "\n\rCould not found data for table: $param1\n\r";
                }
                die;
                break;
            case 'db:drop':
                /** check if param1 is empty */
                if (empty($param1)) {
                    die("\n\rplease provide a database name\n\r");
                }

                $db = new Database;
                $query = "DROP DATABASE ".$param1;
                $db->query($query);
                die("\n\rThat database was successfully dropped\n\r");
                break;
            case 'db:seed':
                //df
                break;

            default:
                die("\n\r unknown command $argv[1] \n\r") ;
                break;
        }
    }
    public function migrate()
    {
        echo "\n\r this is the migrete function\n\r";
    }
    public function make($argv)
    {

        $mode      = $argv[1] ?? null;
        $classname     = $argv[2] ?? null;

        /** check if classname is empty */
        if (empty($classname)) {
            die("\n\rplease provide a class name\n\r");
        }
        /**  clean class name */
        $classname = preg_replace('/[^A-Za-z0-9_\-]/', '', $classname);
        /** check if classname starts with a number */
        if (preg_match("/^[^a-zA-Z_]+/",$classname))
            die("\n\rClass names can't start with numbers \n\r");


        switch($mode) {
            case 'make:controller':
                $filename = 'app'.DS.'controllers'.DS.ucfirst($classname) . '.php';
                if (file_exists($filename)) {
                    die("\n\rThat controller already exists\n\r");
                }
                $sample_file = file_get_contents('app'.DS.'thunder'.DS.'samples'.DS.'controller-sample.php');
                $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($classname), $sample_file);
                $sample_file = preg_replace('/\{classname\}/', strtolower($classname), $sample_file);

                if (file_put_contents($filename, $sample_file)) {
                    die("\n\rThat controller is created successfully\n\r");
                }else{
                    die("\n\rFailed to create Controller due to an error\n\r");
                }
                break;
            case 'make:model':
                $filename = 'app'.DS.'models'.DS.ucfirst($classname) . '.php';
                if (file_exists($filename)) {
                    die("\n\rThat model already exists\n\r");
                }

                $sample_file = file_get_contents('app'.DS.'thunder'.DS.'samples'.DS.'model-sample.php');
                $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($classname), $sample_file);

                /** only add an 's' at the end of table name if not exist*/
                if (!preg_match("/s$/", $classname))
                    $sample_file = preg_replace("/\{table\}/", strtolower($classname).'s', $sample_file);

                if (file_put_contents($filename, $sample_file)) {
                    die("\n\rThat Model was created successfully\n\r");
                }else{
                    die("\n\rFailed to create Controller due to an error\n\r");
                }
                break;
            case 'make:migration':
                //dl
                break;
            case 'make:seeder':
                //df
                break;

            default:
                die("\n\r unknown command $argv[1]") ;
                break;
        }
    }

    public function help()
    {
        echo "
            
            Thunder v$this->version Command line tool
            
            Database 
            db:create            Create a new database schema.
            db:seed              Runs the specified database seeder to poplate known data into the database.
            db:table             retrieves information on the selected database table.
            db:drop              Drop/delete a database table.
            migrate              Locates and runs a migration from the specified plugin folder.
            migrate:refresh      Does a rollback followed by a latest to refresh the current state of the database.
            migrate:rollback     Runs the 'down' method for a  migration the specified plugin folder.
            
            Generators
            make:controller       Create a new controller file.
            make:migration        Create a new migration file.
            make:model            Create a new model file.
            make:seeder           Create a new seeder file.
                
        ";
    }

}
