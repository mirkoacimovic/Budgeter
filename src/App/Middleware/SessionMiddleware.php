<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\SessionException;
use Framework\Contracts\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session already active.");
        }

        if (headers_sent()) {
            throw new SessionException("Headers are already sent.");
        }

        session_set_cookie_params([
            'secure' => $_ENV['APP_ENV'] === 'production',
            'httponly' => true,
            'samesite' => 'lax'
        ]);

        session_start();
        $next();
        session_write_close();
    }
}
