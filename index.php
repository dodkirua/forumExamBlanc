<?php
ini_set("display_errors", E_ALL);
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

if (isset($_GET['ctrl'])) {

}

else {
    IndexController::display();
}