<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\Contact;

/**
 * Class ContactController
 * @package app\controllers
 */
class ContactController extends Controller
{
    /**
     * @param Request $req
     * @return array|string
     */
    public function index(Request $req)
    {
        return $this->render('templates/contact.html.twig');
    }

    public function register(Request $req)
    {
        $contactModel = new Contact();

        if ($req->isPost()) {

            var_dump($req->getBody());

            $contactModel->loadData($req->getBody());

            if ($contactModel->validate() && $contactModel->register()) {
                return "success";
            }
        }

       return $this->render('templates/contact.html.twig');
    }
}