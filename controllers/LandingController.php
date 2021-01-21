<?php


namespace app\controllers;

use app\core\Controller;


/**
 * Class LandingController
 * @package app\controllers
 */
class LandingController extends Controller
{
    /**
     * @return array|string
     */
    public function index()
    {
        return $this->render('landing.html.twig');
    }
}