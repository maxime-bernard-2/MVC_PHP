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

    public function dashboard() {
        if($this->adminCheck()) {
            return $this->render('templates/admin/dashboard.html.twig');
        }
    }

    public function userShow() {
        if($this->adminCheck()) {
            $pdo = Application::$app->db->pdo;
            $stmt = $pdo->prepare("SELECT * FROM User");
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $this->render('templates/admin/user/show.html.twig', array(
                'users' => $result,
            ));
        }
    }

    public function userRemove(Request $request) {
        if($this->adminCheck()) {
            $get = $request->getBody();

            $pdo = Application::$app->db->pdo;
            $stmt = $pdo->prepare("DELETE FROM User WHERE id=?");
            $stmt->execute(array($get['id']));

            $this->redirect('/admin/user');
        }
    }

}
