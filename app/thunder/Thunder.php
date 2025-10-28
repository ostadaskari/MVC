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

    public function list($argv)
    {
        $mode = $argv[1] ?? null;

        switch ($mode) {
            case 'list:migrations':
                 $folder = 'app'.DS.'migrations'.DS;
                 if (!file_exists($folder)) {
                     die("\n\rthere are no migrations\n\r");
                 }
                 $files = glob($folder.'*.php');
                 echo "\n\r Migration files:\n\r";
                 foreach ($files as $file) {
                     echo basename($file). " \n\r";
                 }
                break;

            default:
                //
                break;
        }
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
                $folder = 'app'.DS.'migrations'.DS;
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $filename = $folder . date("jS_M_Y_H_i_s_") . ucfirst($classname) . '.php';
                if (file_exists($filename)) {
                    die("\n\rThat migration file already exists\n\r");
                }

                $sample_file = file_get_contents('app'.DS.'thunder'.DS.'samples'.DS.'migration_sample.php');
                $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($classname), $sample_file);
                $sample_file = preg_replace('/\{classname\}/', strtolower($classname), $sample_file);


                if (file_put_contents($filename, $sample_file)) {
                    die("\n\r Migration file created: " .basename($filename)."\n\r");
                }else{
                    die("\n\rFailed to create Migration file due to an error\n\r");
                }
                break;
            case 'make:seeder':
                //df
                break;

            default:
                die("\n\r unknown command $argv[1]") ;
                break;
        }
    }

    public function migrate($argv)
    {
        $mode = $argv[1] ?? null;
        $filename = $argv[2] ?? null;
        $filename = "app".DS."migrations".DS.$filename;

        if (file_exists($filename)) {
            require $filename;

            preg_match("/[a-zA-Z]+\.php$/",$filename,$match);
            $classname = str_replace('.php','',$match[0]);

            $myclass = new ("\Thunder\\$classname")();

            switch($mode) {
                case 'migrate':
                    $myclass->migrate();
                    echo "\n\rThat migration successful.table is created\n\r";

                    break;

                case 'migrate:rollback':
                    $myclass->down();
                    echo "\n\r table removed \n\r";

                    break;

                case 'migrate:refresh':
                    $myclass->down();
                    $myclass->up();
                    echo "\n\rTable is refreshed \n\r";

                    break;

                default:
                    $myclass->migrate();
                    break;
            }
        }else{
            die("\n\r migration file could not be found !\n\r");
        }

        echo "\n\r migrate successfully : ".basename($filename)." !!!\n\r";
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
            migrate              Locates and runs a migration file.
            migrate:refresh      Runs the 'down' and then 'up' method for a migration file.
            migrate:rollback     Runs the 'down' method for a  migration file.
            
        Generators
            make:controller       Create a new controller file.
            make:migration        Create a new migration file.
            make:model            Create a new model file.
            make:seeder           Create a new seeder file.
            
        Other
            list:migrations       Display List all migrations available.
                
        ";
    }

}
