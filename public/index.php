<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

use app\controllers\AdminController;
use app\controllers\DocumentationController;
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
$app->router->get('/', [LandingController::class, 'index']);
$app->router->get('/login', [UserController::class, 'loginPage']);
$app->router->post('/login', [UserController::class, 'loginPage']);
$app->router->get('/admin', [AdminController::class, 'dashboard']);
$app->router->get('/admin/user', [AdminController::class, 'userShow']);
$app->router->get('/admin/user/remove', [AdminController::class, 'userRemove']);
$app->router->get('/admin/user/edit', [AdminController::class, 'userEdit']);
$app->router->post('/admin/user/edit/send', [AdminController::class, 'userEditSend']);
$app->router->get('/admin/user/add', [AdminController::class, 'userAdd']);
$app->router->post('/admin/user/add/send', [AdminController::class, 'userAddSend']);
$app->router->get('/documentation', [DocumentationController::class, 'index']);

$app->run();
