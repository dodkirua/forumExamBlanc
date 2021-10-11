<?php


namespace Controller\Classes;


class Controller{

    /**
     * display the view called
     * @param string $view
     * @param string $title
     * @param array|null $var
     */
    protected static function render(string $view, string $title, array $var = null) {
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'] . "/View/$view.view.php";
        $html = ob_get_clean();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/View/_partials/base.view.php';
    }
}