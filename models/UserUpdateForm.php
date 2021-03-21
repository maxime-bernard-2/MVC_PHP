<?php

namespace app\models;

use app\core\Application;
use app\core\Model;


class UserUpdateForm extends Model
{
    public string $name;
    public string $roles;
    public string $email;

    public function __construct(int $userId) {

        $user = User::selectWhere(['id' => $userId]);

        $this->name = $user->name;
        $this->roles = $user->roles;
        $this->email = $user->email;
    }

    public function labels(): array
    {
        return [
            'name' => 'Name',
            'email' => 'E-mail',
            'roles' => 'Roles',
        ];
    }

    public function rules()
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => 'App\models\User'
            ]],
            'roles' => [self::RULE_REQUIRED],
        ];
    }

    public function update()
    {
        $user = User::updateWhere(['id' => Application::$app->session->get('user')]);
        if (!$user) {
            $this->addError('email', 'User already exists with this email address');
            return false;
        }

        return true;
    }
}