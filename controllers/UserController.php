<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends Controller
{

    public function loginPage()
    {
        return $this->render('login.html.twig');
    }

    public function logUser() {
        $pdo = Application::$app->db->pdo;

        if (isset($_GET['name'], $_GET['password'])) {
            $name = $_GET['name'];
            $password = $_GET['password'];

            $checkTable = $pdo->query("SELECT * FROM user WHERE name=". $name);
            $result = $checkTable->fetch();

            var_dump($result);
        }

        return $this->render('login.html.twig');
    }

}
