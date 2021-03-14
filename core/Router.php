<?php

declare(strict_types=1);

namespace app\core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class Router
 * @package core
 */
class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];


    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param string $path
     * @param $callback
     */
    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param string $path
     * @param $callback
     */
    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * resolve this route method and path checks its existence and returns the callback function
     * else it just returns 404
     * @return array|string
     */
    public function resolve(): array | string
    {
        $loader = new FilesystemLoader("../views");
        $twig = new Environment($loader);
        $twig->addGlobal('session', $_SESSION);

        $path = $this->request->getPath();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            try {
                return $twig->render("/errors/_404.html.twig");
            } catch (LoaderError | RuntimeError | SyntaxError $e) {
            }
        }

        // if it is a string then we render a the view corresponding to the string
        if (is_string($callback)) {
            return $twig->render($callback);
        }

        // if it is an array we instantiate the controller
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return $callback($this->request);
    }

    /**
     * @param string $path
     */
    public function redirect(string $path): void
    {
        header('Location: ' . $path);
    }

//    /**
//     * @param $view
//     * @param array $params
//     * @return string|string[]
//     */
//    public function renderView($view, $params = [])
//    {
//        $layoutContent = $this->layoutContent();
//        $viewContent = $this->renderOnlyView($view, $params);
//
//        return str_replace('{{ content }}', $viewContent, $layoutContent);
//    }
//
//    /**
//     * @return bool|string
//     */
//    protected function layoutContent()
//    {
//        $layout = Application::$app->controller->layout;
//
//        ob_start();
//        include_once Application::$ROOT_DIR . "/views/templates/$layout.php";
//        return ob_get_clean();
//    }
//
//    /**
//     * @param $view
//     * @param array $params
//     * @return bool|string
//     */
//    protected function renderOnlyView($view, $params = [])
//    {
//        // this is a Variable Variable which transforms the associative array in variables
        // so that we can use it in the views
//        foreach ($params as $key => $val) {
//            $$key = $val;
//        }
//
//        ob_start();
//        include_once Application::$ROOT_DIR . "/views/templates/$view.php";
//        return ob_get_clean();
//    }
}
