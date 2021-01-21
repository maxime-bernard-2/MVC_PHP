<?php


namespace app\controllers;

use app\core\Controller;
use app\core\Request;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends Controller
{

    /**
     * @return array|string
     */
    public function loginPage()
    {
        return $this->render('login');
    }

    public function logUser() {
        if (isset($_GET['name'], $_GET['password'])) {
            $name = $_GET['name'];
            $password = $_GET['password'];

            $sql = "SELECT * FROM user WHERE name=? AND password=?";
            $stmt= $pdo->prepare($sql);
            $stmt->execute([$name, password_hash($password, PASSWORD_BCRYPT)]);
        }
    }

}
