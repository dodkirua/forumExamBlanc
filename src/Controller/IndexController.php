<?php

namespace Dodkirua\Forum\Controller;
use Dodkirua\Forum\Controller\Controller;
use Dodkirua\Forum\Model\Manager\CategoryManager;

class IndexController extends Controller{
    /**
     * display the connect page
     * @param array|null $var
     */
    public static function display(array $var = null) : void{
        $var['subject'] = CategoryManager::getAll();
        $var['title'] = "Bienvenue sur le Forum";
        self::render('index','Accueil',$var);
    }
}