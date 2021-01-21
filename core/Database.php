<?php

namespace app\core;

use PDO;
use PDOException;

/**
 * Class Database
 * @package core
 */
class Database
{
    public PDO $pdo;

    /**
     * Database constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);

        // if there is any error with the connection throw exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function connect(): PDO
    {
        try {
            return new PDO("mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']};port={$_ENV['DATABASE_PORT']}", $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}