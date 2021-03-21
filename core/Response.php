<?php

declare(strict_types=1);

namespace app\core;

/**
 * Class Router
 * @package core
 */
class Response
{
    /**
     * @param int $code
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
}
