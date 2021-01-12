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
        $contact = new Contact();

        if($req->isPost()) {
            //...
        }

        return $this->render('contact');
    }
}