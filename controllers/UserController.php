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

        if (isset($_POST['name'], $_POST['password'])) {
            echo 'oui';
            $name = $_POST['name'];
            $password = $_POST['password'];

            $checkTable = $pdo->query("SELECT * FROM user WHERE name=". $name);
            $result = $checkTable->fetch();

            var_dump($result);
        }
    }

}
