<?php

declare(strict_types=1);

namespace app\core;

/**
 * Class Application
 * @package core
 */
class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;
    public Session $session;

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Application constructor.
     * @param $rootPath
     * @param array $config
     */
    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->response = new Response();
        $this->request = new Request();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    /**
     * Runs the application
     */
    public function run(): void
    {
        echo $this->router->resolve();
    }
}
