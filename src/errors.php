<?php

declare(strict_types=1);

use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpMethodNotAllowedException;

return function (App $app): void {
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    //prevent crash when requesting a url that does not exist
    $errorMiddleware->setErrorHandler(
        HttpNotFoundException::class,
        function ($request, Throwable $exception) use ($app) {
            $response = $app->getResponseFactory()->createResponse();

            $payload = [
                'status' => 'error',
                'message' => 'Route not found',
                'path' => (string)$request->getUri()
            ];

            $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    );

    //prevent the user from using methods like DELETE on /vehicles
    $errorMiddleware->setErrorHandler(
        HttpMethodNotAllowedException::class,
        function ($request, Throwable $exception) use ($app) {
            $response = $app->getResponseFactory()->createResponse();

            $payload = [
                'status' => 'error',
                'message' => 'Method not allowed'
            ];

            $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(405);
        }
    );
};