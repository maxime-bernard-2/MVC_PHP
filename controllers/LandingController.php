<?php


namespace app\controllers;

use app\core\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


/**
 * Class LandingController
 * @package app\controllers
 */
class LandingController extends Controller
{
	/**
	 * @return string
	 */
	public function index(): string
	{
		try {
			return $this->render('landing.html.twig');
		} catch (LoaderError | RuntimeError | SyntaxError $e) {
		}
	}
}
