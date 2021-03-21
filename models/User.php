<?php

namespace app\models;


use app\core\DbModel;
use app\core\UserModel;

class User extends UserModel
{
    public int $id = 0;
    public string $name = '';
    public string $roles = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirm = '';

    public static function tableName(): string
    {
        return 'User';
    }

    public function attributes(): array
    {
        return ['name', 'email', 'roles', 'password'];
    }

    public function labels(): array
    {
        return [
            'name' => 'Name',
            'email' => 'E-mail',
            'roles' => 'Roles',
            'password' => 'Password',
            'passwordConfirm' => 'Password Confirm'
        ];
    }

    public function rules()
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'roles' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirm' => [[self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}