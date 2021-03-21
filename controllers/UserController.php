<?php

declare(strict_types=1);

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
    }

    public function signupPage(Request $request)
    {  
    }

    public function logout(Request $request)
    {
        $this->redirect('/admin');
    }
}
