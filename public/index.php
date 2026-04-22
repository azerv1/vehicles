<?php

declare(strict_types=1);


use Slim\Factory\AppFactory;
require __DIR__ . '/../vendor/autoload.php';

$pdo = require __DIR__ . '/../src/db.php';
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
(require __DIR__ . '/../src/errors.php')($app);
(require __DIR__ . '/../src/routes.php') ($app, $pdo);
$app->run();