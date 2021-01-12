<?php


require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\ContactController;
use app\core\Application;

$app = new Application(dirname(__DIR__));
$app->loadEnv();

/* Example of usage for routing */
$app->router->get('/contact', [ContactController::class, 'index']);
$app->router->post('/contact', [ContactController::class, 'handleContact']);

$app->run();