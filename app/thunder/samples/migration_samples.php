<?php


namespace Migration;
defined('ROOTPATH') or exit('Access Denied');

/*
* {CLASSNAME} class (model)
*/

class {CLASSNAME}

{
    use Migration;

    protected $keys = '{table}';

    public function up(){

        /** allowed methods */

//        $this->addColumn();
//        $this->addPrimaryKey();
//        $this->addUniqueKey();
//
//        $this->addData();
//        $this->insert();
//
//        $this->createTable();


    }

    public function down(){
        $this->dropTable('{classname}');
    }

}