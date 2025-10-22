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



}