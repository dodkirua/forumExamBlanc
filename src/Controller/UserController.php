<?php

namespace Dodkirua\Forum\Controller;

class UserController extends Controller{

    public static function registration(){
        $var['title'] = "Création de compte";
        self::render('registration','Création de compte',$var);
    }

    public static function addUser(){

    }
}