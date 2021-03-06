<?php

use app\core\Application;

class m0001_initial
{
	public function up(): void
	{
		// Some SQL
		$db = Application::$app->db;

        $SQL = "
        CREATE TABLE User (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            roles varchar(255) NOT NULL,
            connection_number INT DEFAULT 0,
            last_connection DATETIME
        );";

		$db->pdo->exec($SQL);
	}

	public function down()
	{
		// Some SQL
		/*
		$db = \app\core\Application::$app->db;
		$SQL = "DROP TABLE test()";
		$db->pdo->exec($SQL);
		*/
	}
}
