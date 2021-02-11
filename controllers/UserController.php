<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Router;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends Controller
{

    public function loginPage(Request $request) {
        if ($request->isPost()) {
            $pdo = Application::$app->db->pdo;

            if (isset($_POST['name'], $_POST['password'])) {
                $post = $request->getBody();

                $stmt = $pdo->prepare("SELECT * FROM User WHERE name=?");
                $stmt->execute(array($post['name']));
                $result = $stmt->fetch();

                if (password_verify($post['password'], $result['password'])) {
                    $_SESSION['user'] = array(
                        'name' => $result['name'],
                        'email' => $result['email'],
                    );

                    $this->redirect('/');
                } else {
                    return $this->render('templates/login.html.twig', array(
                        'error' => 'Mot de passe ou Username invalide'
                    ));
                }

            }
        } else {
            return $this->render('templates/login.html.twig');
        }
    }

}
