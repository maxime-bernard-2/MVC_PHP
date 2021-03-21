<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\UserLoginForm;
use app\models\UserUpdateForm;

class UserController extends Controller
{

    public function home()
    {
        return $this->render('home');
    }

    public function login(Request $request)
    {
        $loginForm = new UserLoginForm();
        if ($request->method() === 'post') {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                return;
            }
        }
        // $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm,
        ]);
    }

    public function register(Request $request)
    {
        $registerModel = new User();
        if ($request->method() === 'post') {
            $registerModel->loadData($request->getBody());
            if ($registerModel->validate() && $registerModel->save()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                return 'Show success page';
            }

        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel,
        ]);
    }

    public function update(Request $request)
    {
        $updateForm = new UserUpdateForm(Application::$app->session->get('user'));
        if ($request->method() === 'post') {
            $updateForm->loadData($request->getBody());
            if ($updateForm->validate() && $updateForm->update()) {
                Application::$app->session->setFlash('success', 'Updated Sucessfully');
                Application::$app->response->redirect('/');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('update', [
            'model' => $updateForm,
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function profile()
    {
        return $this->render('profile');
    }
}
