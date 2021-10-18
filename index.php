<?php

use Dodkirua\Forum\Controller\CategoryController;
use Dodkirua\Forum\Controller\IndexController;
use Dodkirua\Forum\Controller\UserController;

ini_set("display_errors", E_ALL);
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

if (isset($_GET['ctrl'])) {
    switch ($_GET['ctrl']){
        case 'form' :
            switch ($_GET['action']){
                case 'login' :
                    LoginController::display();
                    break;

            }
            break;
        case 'category' :
            CategoryController::display();
            break;
        case 'registration' :
            UserController::registration();
            break;
    }
}

else {
    IndexController::display();
}