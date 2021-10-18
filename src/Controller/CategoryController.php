<?php

namespace Dodkirua\Forum\Controller;

use Dodkirua\Forum\Model\Manager\CategoryManager;
use Dodkirua\Forum\Model\Manager\RemarkManager;
use Dodkirua\Forum\Model\Manager\RoleManager;
use Dodkirua\Forum\Model\Manager\TopicManager;

class CategoryController extends Controller{

    /**
     * display the category
     * @param array|null $var
     */
    public static function display(array $var = null) {
        if(isset($_GET['val'])){
            $var['topic'] = TopicManager::getAllByCategory($_GET['val']);
            $var['category'] = CategoryManager::getById($_GET['val']);
        }
        else {
            $var['topic'] = TopicManager::getAllByCategory(1);
            $var['category'] = CategoryManager::getById(1);
        }
        foreach ($var['topic'] as $topic){
            $topicId = $topic->getId();
            $var['remark'][$topicId] = RemarkManager::getAllByTopic(1);
            var_dump($var['remark']);
        }
        $var['title'] = "Bienvenue dans la catégorie " . mb_strtoupper($var['category']->getName());
        $var['css'] = "index";
        self::render('category','Accueil',$var);
    }
}