<?php

namespace Model;
defined('ROOTPATH') OR exit('Access Denied');
/*
* {CLASSNAME} class (model)
*/
class {CLASSNAME}
{
    use \Core\Model;

    protected $table = '{table}';
    protected $primaryKey = 'id';

    protected $loginUniqueColumn = 'email';
    protected $allowedColumns = [
    'username',
    'email',
    'password',
];

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