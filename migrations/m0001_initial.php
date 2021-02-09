<?php

use app\core\Application;

class m0001_initial {
    public function up()
    {
        // Some SQL
        $db = Application::$app->db;

        $SQL = "CREATE TABLE Contact (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname varchar(255) NOT NULL,
            lastname varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            password varchar(255) NOT NULL
        );
        CREATE TABLE User (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            roles varchar(255) NOT NULL
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
