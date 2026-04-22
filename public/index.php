<?php

declare(strict_types=1);


use Slim\Factory\AppFactory;
require __DIR__ . '/../vendor/autoload.php';

$pdo = require __DIR__ . '/../src/db.php';
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

(require __DIR__ . '/../src/routes.php') ($app, $pdo);
$app->run();