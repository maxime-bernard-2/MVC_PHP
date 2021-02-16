<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\Contact;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
	public function index(Request $req): array|string
	{
		return $this->render('templates/contact.html.twig');
	}

	public function register(Request $req): string
	{
		$contactModel = new Contact();

		if ($req->isPost()) {

			var_dump($req->getBody());

			$contactModel->loadData($req->getBody());

			if ($contactModel->validate() && $contactModel->register()) {
				return "success";
			}
		}

		try {
			return $this->render('templates/contact.html.twig');
		} catch (LoaderError | RuntimeError | SyntaxError $e) {
		}
	}
}