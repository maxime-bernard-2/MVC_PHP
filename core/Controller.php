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
    public function render($view, $params = []): string
    {
        $loader = new FilesystemLoader("../views");
        $twig = new Environment($loader);

        return $twig->render($view, $params);
    }

    /**
     * @param string $path
     */
    public function redirect(string $path): void
    {
        Application::$app->router->redirect($path);
    }

    public function adminCheck(): bool
    {
        $pdo = Application::$app->db->pdo;
        if(isset($_SESSION['user'])) {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE name=?");
            $stmt->execute(array($_SESSION['user']['name']));
            $result = $stmt->fetch();

            if($result['roles'] === 'ROLE_ADMIN') {
                return true;
            } else {
                return false;
            }
        } else {
            $this->redirect('/login');
        }
    }
}
