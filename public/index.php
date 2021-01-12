<?php

require_once __DIR__.'/vendor/autoload.php';
use app\core\Application;

$app = new Application(dirname(__DIR__));

/* Example of usage for routing
$app->router->get('/', [ContactController::class, 'index']);
$app->router->get('/contact', [ContactController::class, 'contact']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/test_func', function () {
    return 'Hello UwU 🙌';
});

$app->router->post('/contact', [ContactController::class, 'handleContact']);
$app->router->post('/register', [AuthController::class, 'register']);
*/

$app->run();