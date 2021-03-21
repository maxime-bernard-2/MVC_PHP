<?php

declare(strict_types=1);

namespace app\core\middlewares;


abstract class BaseMiddleware
{
    abstract public function execute();
}