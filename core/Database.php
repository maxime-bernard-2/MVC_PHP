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
            return new PDO("mysql:host=database;dbname=hothothot;port=3306", 'hothothot', 'kJI6zkVYcXmo6Ebt');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}