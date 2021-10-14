<?php

use Dodkirua\Forum\Controller\IndexController;

ini_set("display_errors", E_ALL);
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

if (isset($_GET['ctrl'])) {
    switch ($_GET['ctrl']){
        case 'form' :
            switch ($_GET['action']){
                case 'login' :
                    LoginController::display();
            }
    }
}

else {
    IndexController::display();
}