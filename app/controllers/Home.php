<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied');
use \Model\User;
class Home 

{
    use \Controller;
    public function index(){

        // $model = new Model;
        // $arr['id']= 1;
        // $arr['name']= 'ali'; //
        // $arr2['name']= 'john'; //
        // $arr2['date']= date("Y"); //
        // $result = $model->where($arr); //where
        // show($result);



        // $arr['name'] = 'peter';
        // $arr['age'] = 45;
        // $result = $model->insert($arr);
        // show($result);



        // $result = $model->delete(3);
        // show($result);

        // $arr['name'] = 'ahmad';
        // $arr['age'] = '50';
        // $result = $model->update(2,$arr);
        // show($result);


        /* 8
        With user model
        */


        // $user= new User;
        // $arr['name'] = 'asghar';
        // $arr['age'] = 56;
        // $result= $user->insert($arr);

        // $user= new User;
        // $result= $user->where(['id'=> 1]);
        // show($result);


        // $user= new User;
        // $result= $user->findAll();
        // show($result);


        $user = new User();
        if ($user->validate($_POST)){
            $user->insert($_POST);
            redirect("login");
        }

       // $user->signup($_POST)
        $data['user']= $user;
       $this->view('home',$data);
    }

    // public function edit($a ='',$b ='',$c =''){
    //   show('from edit metod');
    //    $this->view('home');
    // }
}

