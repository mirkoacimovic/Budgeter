<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};
use App\Config\Paths;
use Dotenv\Dotenv;

$environment = Dotenv::createImmutable(Paths::ROOT);
$environment->load();

$app = new App(Paths::SOURCE . 'App/container-definitions.php');
registerRoutes($app);
registerMiddleware($app);
return $app;
