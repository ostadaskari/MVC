<?php


namespace Thunder;


defined('ROOTPATH') or exit('Access Denied');

/*
* {CLASSNAME} class
*/

class {CLASSNAME} extends Migration
{

    public function up(){
        /************************ allowed methods */

/** create a table  */
//        $this->addColumn();
//        $this->addPrimaryKey();
//        $this->addUniqueKey();
//        $this->createTable();

/** insert data  */
//        $this->addData();
//        $this->insertData();
//
        /***********************end  allowed methods */


            // create table
            $this->addColumn('id int(11) NOT NULL AUTO_INCREMENT ');
            $this->addColumn('date_created datetime NULL ');
            $this->addColumn('date_updated datetime NULL ');

            $this->addPrimaryKey('id');

            $this->createTable('{classname}');

            //insert data
            $this->addData('date_created',date("Y-m-d H:i:s"));
            $this->addData('date_updated',date("Y-m-d H:i:s"));

            $this->insertData('{classname}');

    }

    public function down(){
        $this->dropTable('{classname}');
    }

}