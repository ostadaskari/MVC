<?php

namespace Model;
defined('ROOTPATH') OR exit('Access Denied');
/* 
* User class (model)
*/
class User 
{
    use \Core\Model;
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $loginUniqueColumn = 'email';
/** *******************************************
 * VALIDATION RULES
 *
 * 'required',
 * 'alpha',
 * 'alpha_space',
 * 'email',
 * 'numeric',
 * 'unique',
 * 'symbol',
 * 'longer_than_8_character',
 * 'alpha_numeric_symbol',
 * 'alpha_symbol',
 * 'alpha_numeric',
 *********************************************/
    protected $allowedColumns = [
        'username',
        'email',
        'password',
    ];

    protected $validationRules = [
        'email' => [
            'email',
            'unique',
            'required',
        ],
        'username' => [
            'alpha_space',
            'required',
        ],
        'password' => [
            'longer_than_8_characters',
            'required',
        ],
    ];

    public function signup($data)
    {
        if ($this->validate($data)){
            // add extra user columns here
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['date'] = date('Y-m-d H:i:s');
//            $data['date_created'] = date('Y-m-d H:i:s');

            $this->insert($data);
            redirect("login");
        }
    }

    public function login($data)
    {
        $row = $this->first([$this->loginUniqueColumn => $data[$this->loginUniqueColumn]]);
        if ($row){

            //confirm user details
            if (password_verify($data['password'], $row->password)) {
                $ses = new \Model\Session();
                $ses->auth($row);
                redirect("home");
            }else{
                $this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or Password";
            }
        }else{
            $this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or Password";
        }
    }



}