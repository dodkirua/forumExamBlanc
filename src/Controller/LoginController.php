<?php

namespace Dodkirua\Forum\Controller;

class LoginController extends Controller{
    /**
     * display login page
     * @param array|null $var
     */
    public static function display(array $var = null){
        self::render('login','Page de connection',$var);
    }

    /**
     * test connection to a user
     * return :
     * 1 : ok
     * -6 : wrong password
     * -5 : $_POST variable problem
     * -9 : unknown username
     * @return int
     */
    public static function connection() : int{
        if (isset($_POST['username']) && isset($_POST['pass'])){
            $username = mb_strtolower($_POST['username']);
            $pass = $_POST['pass'];
            return self::userInfo($username,$pass);
        }
        return -5;
    }
}