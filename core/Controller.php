<?php


namespace app\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Controller
 * @package core
 */
class Controller
{

//    public string $layout = 'base';
//
//    /**
//     * sets the layout, by default it is base.html.twig
//     * @param String $layout
//     */
//    public function setLayout(string $layout): void
//    {
//        $this->layout = $layout;
//    }

    /**
     * @param $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $loader = new FilesystemLoader("../views");
        $twig = new Environment($loader);

        return $twig->render($view, $params);
    }
}