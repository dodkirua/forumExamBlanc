<?php

namespace Dodkirua\Forum\Controller;
use Dodkirua\Forum\Controller\Controller;

class IndexController extends Controller{
    /**
     * display the connect page
     * @param array|null $var
     */
    public static function display(array $var = null) : void{

        self::render('index','Accueil',$var);
    }
}