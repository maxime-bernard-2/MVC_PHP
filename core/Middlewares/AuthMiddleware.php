<?php

declare (strict_types=1);

namespace app\core\middlewares;


use app\core\Application;
use Exception;

// use app\core\ForbiddenException;


class AuthMiddleware extends BaseMiddleware
{
    protected array $actions = [];

    public function __construct($actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new Exception("test forbidden");
            }
        }
    }
}