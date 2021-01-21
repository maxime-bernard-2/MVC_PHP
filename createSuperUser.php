<?php
/**
 * Script to generate an admin user
 * use: php createSuperUser.php username password
 */

session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

use app\controllers\ContactController;
use app\controllers\UserController;
use app\core\Application;
use app\core\Database;

$db = new Database();
$pdo = $db->connect();
$app = new Application(dirname(__DIR__));

if (isset($argv[1], $argv[2])) {
    $name = $argv[1];
    $password = $argv[2];

    $checkTable = $pdo->query("SELECT 1 FROM user");
    if ($checkTable) {
        $sql = "INSERT INTO user (name, password, role) VALUES (?,?,?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$name, $password, 'ROLE_ADMIN']);
    } else {
        echo 'Erreur: Table user non existante';
    }
} else {
    echo 'ERREUR';
}


