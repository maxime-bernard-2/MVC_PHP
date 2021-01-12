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