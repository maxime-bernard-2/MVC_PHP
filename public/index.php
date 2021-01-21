<?php
require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

use app\controllers\HelloWorldController;
use app\core\Application;
use app\core\Database;

$config = [
    'db' => [
        'dsn' => "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']};port={$_ENV['DATABASE_PORT']}",
        'user' => $_ENV['DATABASE_USER'],
        'password' => $_ENV['DATABASE_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

/* Example of usage for routing */
$app->router->get('/helloworld', [HelloWorldController::class, 'index']);
$app->router->get( '/phpinfos', function () {
    return phpinfo();
});
$app->router->get('/contact', [ContactController::class, 'index']);
$app->router->post('/contact', [ContactController::class, 'handleContact']);
$app->router->get('/login', [UserController::class, 'loginPage']);
$app->router->get('/login/check', [UserController::class, 'logUser']);

$app->run();
