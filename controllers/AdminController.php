<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

/**
 * Class UserController
 * @package app\controllers
 */
class AdminController extends Controller
{

    public function dashboard()
    {
        if ($this->adminCheck()) {
            return $this->render('templates/admin/dashboard.html.twig');
        }
    }

    public function userShow()
    {
        if ($this->adminCheck()) {
            $pdo = Application::$app->db->pdo;
            $stmt = $pdo->prepare("SELECT * FROM User");
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $this->render('templates/admin/user/show.html.twig', array(
                'users' => $result,
            ));
        }
    }

    public function userRemove(Request $request)
    {
        if ($this->adminCheck()) {
            $get = $request->getBody();

            $pdo = Application::$app->db->pdo;
            $stmt = $pdo->prepare("DELETE FROM User WHERE id=?");
            $stmt->execute(array($get['id']));

            $this->redirect('/admin/user');
        }
    }

    public function userEdit(Request $request)
    {
        if ($this->adminCheck()) {
            $get = $request->getBody();

            $pdo = Application::$app->db->pdo;
            $stmt = $pdo->prepare("SELECT * FROM User WHERE id=?");
            $stmt->execute(array($get['id']));
            $result = $stmt->fetch();

            return $this->render('templates/admin/user/edit.html.twig', array(
                'user' => $result,
            ));
        }
    }

    public function userEditSend(Request $request)
    {
        if ($this->adminCheck()) {
            if ($request->isPost()) {
                $post = $request->getBody();
                $pdo = Application::$app->db->pdo;

                $stmt = $pdo->prepare("UPDATE User SET name=?, email=?, roles=? WHERE id=?");
                $stmt->execute(array(
                    $post['name'],
                    $post['email'],
                    $post['role'] === 'Admin' ? 'ROLE_ADMIN' : 'ROLE_USER',
                    $post['id']
                ));

                $this->redirect('/admin/user');
            }
        }
    }

    public function userAdd(Request $request)
    {
        if ($this->adminCheck()) {
            $get = $request->getBody();

            $pdo = Application::$app->db->pdo;
            $stmt = $pdo->prepare("SELECT * FROM User WHERE id=?");
            $stmt->execute(array($get['id']));
            $result = $stmt->fetch();

            return $this->render('templates/admin/user/add.html.twig', array(
                'user' => $result,
            ));
        }
    }

    public function userAddSend(Request $request)
    {
        if ($this->adminCheck()) {
            if ($request->isPost()) {
                $post = $request->getBody();
                $pdo = Application::$app->db->pdo;

                $stmt = $pdo->prepare("INSERT INTO User (name, email, password, roles) VALUES (?, ?, ?, ?)");
                $stmt->execute(array(
                    $post['name'],
                    $post['email'],
                    password_hash($post['password'], PASSWORD_DEFAULT),
                    $post['role'] === 'Admin' ? 'ROLE_ADMIN' : 'ROLE_USER',
                ));

                $this->redirect('/admin/user');
            }
        }
    }

}
