<?php
/**
 * Session Class
 * Save or read data to the current session
 */
namespace Model;

defined('ROOTPATH') OR exit('Access Denied');

class Session
{

    public $mainkey = 'APP';
    public $userkey = 'USER';
    private function start_session():int
    {
        if(session_start() === PHP_SESSION_NONE){
            session_start();
        }
        return 1;
    }

    /** put data into the session */
    public function set(mixed $keyOrArray, mixed $value = ''): int
    {
        $this->start_session();

        if(is_array($keyOrArray))
        {
            foreach ($keyOrArray as $key => $value) {
                $_SESSION[$this->mainkey][$key] = $value;
            }
            return 1;
        }
        $_SESSION[$this->mainkey][$keyOrArray] = $value;
        return 1;
    }

    /**
     * get data from the session . default is return if data not found
     */
    public function get(string $key, mixed $default = ''): mixed
    {

        $this->start_session();
        if(isset($_SESSION[$this->mainkey][$key]))
        {
            return $_SESSION[$this->mainkey][$key];
        }
        return $default;
    }

    /** saves the user row data into the session after login */
    public function auth(mixed $user_row): int
    {
        $this->start_session();
        $_SESSION[$this->userkey] = $user_row;
        return 0;
    }

    /** removes user data from the session */
    public function logout():int
    {
        $this->start_session();
        if(isset($_SESSION[$this->userkey])){
            unset($_SESSION[$this->userkey]);
        }
        return 0;
    }
    /** check if user is logged in */
    public function is_logged_in():bool
    {
        $this->start_session();
        if(isset($_SESSION[$this->userkey])){
            return true;
        }
        return false;
    }

    public function is_admin():bool
    {
        $this->start_session();
        $db = new \Core\Database();

        if(isset($_SESSION[$this->userkey])){
            $arr = [];
            $arr['id'] = $_SESSION[$this->userkey]->role_id;

            if($db->get_row("select * from auth_roles where id = :id && role = 'admin' limit 1", $arr)){
                return true;
            }
        }
        return false;
    }

    /** gets data from a column in the session user data */
    public function user(string $key = '', mixed $default = ''):mixed
    {
        $this->start_session();
        if(empty($key) && isset($_SESSION[$this->userkey])){
            return $_SESSION[$this->userkey];
        }else
            if(isset($_SESSION[$this->userkey]->$key)){
                return $_SESSION[$this->userkey]->$key;
            }
            return $default;

    }

    /** return data from a key and deletes it */
    public function pop(string $key, mixed $default):mixed
    {
        $this->start_session();
        if(isset($_SESSION[$this->mainkey][$key])){

            $value = $_SESSION[$this->mainkey][$key];
            unset($_SESSION[$this->mainkey][$key]);
            return $value;
        }
        return $default;
    }

    public function all():mixed
    {
        $this->start_session();
        if(isset($_SESSION[$this->mainkey])){
            return $_SESSION[$this->mainkey];
        }
        return [];
    }



}