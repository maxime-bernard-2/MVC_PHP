<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

use app\controllers\ContactController;
use app\controllers\HelloWorldController;
use app\controllers\LandingController;
use app\controllers\UserController;
use app\core\Application;

$config = [
    'db' => [
        'dsn' => "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']};port={$_ENV['DATABASE_PORT']}",
        'user' => $_ENV['DATABASE_USER'],
        'password' => $_ENV['DATABASE_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

/* Example of usage for routing */
$app->router->get('/login', [UserController::class, 'loginPage']);
$app->router->post('/login', [UserController::class, 'loginPage']);
$app->router->get('/helloworld', [HelloWorldController::class, 'index']);
$app->router->get('/contact', [ContactController::class, 'register']);
$app->router->post('/contact', [ContactController::class, 'register']);
$app->router->get('/', [LandingController::class, 'index']);

$app->run();
