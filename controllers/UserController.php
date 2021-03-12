<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Router;
use app\models\User;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends Controller
{

    public function loginPage(Request $request)
    {
        if ($request->isPost()) {
            $pdo = Application::$app->db->pdo;
            $post = $request->getBody();

            $stmt = $pdo->prepare("SELECT * FROM User WHERE name=?");
            $stmt->execute(array($post['name']));
            $result = $stmt->fetch();

            if (password_verify($post['password'], $result['password'])) {
                $user = new User();
                $user->setName($result['name']);
                $user->setEmail($result['email']);
                $user->setRole($result['roles']);

                $user->connectionNumberUpdate();
                $user->lastConnectionUpdate();


                $_SESSION['user'] = get_object_vars($user);

                $this->redirect('/');
            } else {
                return $this->render('templates/login.html.twig', array(
                    'error' => 'Password or username invalid'
                ));
            }
        } else {
            return $this->render('templates/login.html.twig');
        }
    }

    public function signupPage(Request $request)
    {
        if ($request->isPost()) {
            $pdo = Application::$app->db->pdo;
            $post = $request->getBody();

            if ($post['password'] === $post['confirm_password'] && !empty($post['password'])) {
                if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                    $stmt = $pdo->prepare("SELECT * FROM User WHERE name=?");
                    $stmt->execute(array($post['name']));
                    $result = $stmt->fetch();

                    if (!$result) {
                        $stmt = $pdo->prepare("SELECT * FROM User WHERE email=?");
                        $stmt->execute(array($post['email']));
                        $result = $stmt->fetch();

                        if (!$result) {
                            $sql = "INSERT INTO User (name,email, password, roles) VALUES (?,?,?,?)";
                            $stmt= $pdo->prepare($sql);
                            $stmt->execute([$post['name'],$post['email'], password_hash($post['password'], PASSWORD_DEFAULT), 'ROLE_USER']);

                            $this->redirect('/login');
                        } else {
                            return $this->render('templates/signup.html.twig', array(
                                'error' => 'Email already used'
                            ));
                        }
                    } else {
                        return $this->render('templates/signup.html.twig', array(
                            'error' => 'Username already used'
                        ));
                    }

                } else {
                    return $this->render('templates/signup.html.twig', array(
                        'error' => 'Email not valid'
                    ));
                }
            } else {
                return $this->render('templates/signup.html.twig', array(
                    'error' => 'Password not identical'
                ));
            }
        } else {
            return $this->render('templates/signup.html.twig');
        }
    }

    public function logout(Request $request)
    {
        session_unset();

        $this->redirect('/admin');
    }

}
