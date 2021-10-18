<?php

namespace Dodkirua\Forum\Controller;
use Dodkirua\Forum\Controller\Controller;
use Dodkirua\Forum\Model\Entity\Category;
use Dodkirua\Forum\Model\Manager\CategoryManager;
use Dodkirua\Forum\Model\Manager\TopicManager;

class IndexController extends Controller{
    /**
     * display the connect page
     * @param array|null $var
     */
    public static function display(array $var = null) : void{
        $var['subject'] = CategoryManager::getAll();
        $var['css'] = 'index';
        for ($i = 0 ; $i < count($var['subject']); $i++){
           $var['topic'][$i] = TopicManager::getAllByCategory($var['subject'][$i]->getId());
        }
        $var['title'] = "Bienvenue sur le Forum";
        self::render('index','Accueil',$var);
    }
}