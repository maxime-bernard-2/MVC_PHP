<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

use app\core\Application;

$config = [
	'db' => [
		'dsn' => "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']};port={$_ENV['DATABASE_PORT']}",
		'user' => $_ENV['DATABASE_USER'],
		'password' => $_ENV['DATABASE_PASSWORD'],
	]
];

$app = new Application(__DIR__, $config);

$app->db->applyMigrations();