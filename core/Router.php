<?php

declare(strict_types=1);

namespace app\core;

use Exception;

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
    public function resolve()
    {
        $method = $this->request->method();
        $url = $this->request->getPath();
        $callback = $this->routes[$method][$url] ?? false;
        if (!$callback) {
            throw new Exception();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            /**
             * @var $controller \thecodeholic\phpmvc\Controller
             */
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            $middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderViewOnly($view, $params = [])
    {
        return Application::$app->view->renderViewOnly($view, $params);
    }
}
