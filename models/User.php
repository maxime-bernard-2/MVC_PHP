<?php


namespace app\models;

use app\core\DBModel;

/**
 * Class User
 * @package app\models
 */
class User extends DBModel
{
    public string $name;
    public string $email;
    public string $password;
    public array $roles;

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
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }
}
