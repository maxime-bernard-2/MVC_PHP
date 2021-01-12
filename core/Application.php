<?php

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
     */
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     * Runs the application
     */
    public function run(): void
    {
        echo $this->router->resolve();
    }
  
     public function loadEnv()
     {
         $handle = @fopen(".env", 'rb');

         if ($handle) {
             while (($buffer = fgets($handle, 4096)) !== false) {
                 if ($buffer[0] !== '#' && !ctype_space($buffer)) {
                     $contant = explode('=', $buffer);
                     $_ENV[$contant[0]] = $contant[1];
                 }
             }
             if (!feof($handle)) {
                 echo "Erreur: veuillez verifier votre .env\n";
             }
             fclose($handle);
         }
     }
}