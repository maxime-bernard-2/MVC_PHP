<?php

namespace app\core;

use PDO;

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
     * This Applies the migrations found in migrations folder
     */
    public function applyMigrations(): void
    {
        // First we create ihe migration table if it doesnt exists
        $this->createMigrationsTable();
        // We fetch the applied migration to find the difference between applied and to apply migrations
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR.'/migrations');

        $newMigrations = [];

        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            // Here we apply the the missing migrations
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className();
            $this->log("Applying migration $migration . . .");
            // we call the migration up & down functions
            $instance->up();
            $instance->down();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are already applied");
        }
    }

    /**
     *  This creates the migration table
     */
    public function createMigrationsTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
            ) ENGINE=INNODB;
       ");
    }

    /**
     * Returns array of already applied migrations
     * @return array
     */
    public function getAppliedMigrations(): array
    {
        $statement = $this->pdo->query("SELECT migration FROM migrations");

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Here we save the applied migrations in the migrations table
     * @param array $newMigrations
     */
    public function saveMigrations(array $newMigrations): void
    {
        // Only in php 7.4, We transform the array into a string that can be put in SQL format
        $valMigrations = implode(",", array_map(fn($m) => "('$m')", $newMigrations));

        $this->pdo->exec("INSERT INTO migrations (migration) VALUES 
            $valMigrations
        ");
    }

    /**
     * log format for terminal console
     * @param $message
     */
    protected function log($message): void
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
