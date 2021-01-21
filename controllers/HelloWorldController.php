<?php


namespace app\controllers;

use app\core\Controller;


/**
 * Class ContactController
 * @package app\controllers
 */
class HelloWorldController extends Controller
{
    /**
     * @return array|string
     */
    public function index(): array|string
    {
        return $this->render('templates/helloworld.html.twig', array(
            "name" => "Salut toi !"
        ));
    }
}