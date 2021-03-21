<?php

/**
 * Script to generate an admin user
 * use: php createSuperUser.php username password
 */

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/../../');
$dotenv->load();

use app\core\Application;

$config = [
    'db' => [
        'dsn' => "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']};port={$_ENV['DATABASE_PORT']}",
        'user' => $_ENV['DATABASE_USER'],
        'password' => $_ENV['DATABASE_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$pdo = $app->db->pdo;

if (isset($argv[1], $argv[2], $argv[3])) {
    $name = $argv[1];
    $email = $argv[2];
    $password = $argv[3];

    $checkTable = $pdo->query("SELECT 1 FROM User");
    if ($checkTable) {
        $sql = "INSERT INTO User (name,email, password, roles) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name,$email, password_hash($password, PASSWORD_DEFAULT), 'ROLE_USER']);
    } else {
        echo 'Erreur: Table user non existante';
    }
} else {
    echo 'ERREUR';
}
