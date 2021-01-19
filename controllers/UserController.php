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
     * @param Request $req
     * @return array|string
     */
    public function loginPage(Request $req)
    {
        return $this->render('login');
    }

}