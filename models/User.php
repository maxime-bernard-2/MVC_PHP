<?php


namespace app\models;

use app\core\Application;
use app\core\DBModel;
use DateTime;

/**
 * Class User
 * @package app\models
 */
class User extends DBModel
{
    public string $name;
    public string $email;
    public string $role;

    public function tableName(): string
    {
        return 'User';
    }

    public function attributes(): array
    {
        return ['name', 'email', 'password', 'roles'];
    }

    public function rules() : array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_EMAIL],
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @param int $connectionNumber
     */
    public function connectionNumberUpdate(): void
    {
        $pdo = Application::$app->db->pdo;
        $sql = "UPDATE User SET connection_number=connection_number + 1 WHERE email=?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$this->email]);
    }

    /**
     * @param DateTime $lastConnection
     */
    public function lastConnectionUpdate(): void
    {
        $pdo = Application::$app->db->pdo;
        $date = new \DateTime('NOW');
        $sql = "UPDATE User SET last_connection=? WHERE email=?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$date->format('Y-m-d H:i:s'),$this->email]);

    }
}
