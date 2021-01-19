<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/../');
$dotenv->load();

use app\controllers\ContactController;
use app\controllers\UserController;
use app\core\Application;
use app\core\Database;

$db = new Database();
$db->connect();
$app = new Application(dirname(__DIR__));

/* Example of usage for routing */
$app->router->get('/contact', [ContactController::class, 'index']);
$app->router->post('/contact', [ContactController::class, 'handleContact']);
$app->router->get('/login', [UserController::class, 'loginPage']);

$app->run();