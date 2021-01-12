<?php


namespace app\core;

/**
 * Class Controller
 * @package core
 */
class Controller
{
    public string $layout = 'base';

    /**
     * sets the layout, by dfault it is base.php  v
     * @param String $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @param $view
     * @param array $params
     * @return string|string[]
     */
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
}