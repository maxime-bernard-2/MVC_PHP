<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\models\Documentation;

class DocumentationController extends Controller
{
    public function index()
    {

        $documentation = new Documentation();

        return $this->render('docs/documentation.html.twig', array(
            'test' => 'Une phrase de test'
        ));
    }
}
