<?php

declare(strict_types=1);

namespace App\Config;

use App\Middleware\CsrfGuardMiddleware;
use App\Middleware\CsrfTokenMiddleware;
use Framework\App;
use App\Middleware\TemplateDataMiddleware;
use App\Middleware\ValidationExceptionMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\FlashMiddleware;

function registerMiddleware(App $app)
{
    $app->addMiddleware(CsrfGuardMiddleware::class);
    $app->addMiddleware(CsrfTokenMiddleware::class);
    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(FlashMiddleware::class);
    $app->addMiddleware(SessionMiddleware::class);
}
