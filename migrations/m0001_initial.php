<?php

use app\core\Application;

class m0001_initial {
    public function up()
    {
        // Some SQL
        $db = Application::$app->db;

        $SQL = "CREATE TABLE Persons (
            PersonID int,
            LastName varchar(255),
            FirstName varchar(255),
            Address varchar(255),
            City varchar(255)
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