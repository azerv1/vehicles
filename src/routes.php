<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


return function (App $app, PDO $pdo): void {


    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('API is running');
        return $response;
    });

    $app->get('/vehicles', function (Request $request, Response $response) use ($pdo) {
        $params = $request->getQueryParams();
        $sort = $params['sort'] ?? 'asc';
        //4 shorting options
        $sorting_choices =  [
            'name_asc' => 'model_name ASC',
            'name_desc'=> 'model_name DESC',
            'price_asc'=> 'price ASC',
            'price_desc'=> 'price DESC',
        ];
        $sorting_query = $sorting_choices[$sort] ?? 'id ASC';

        $basic_querry = 'SELECT id, model_name, type_id, vehicle_type, doors, transmission, fuel, price FROM vehicles WHERE 1=1';

        $extra_params = [];

        if (!empty($params["transmission"])) {
            $basic_querry .= " AND transmission= :transmission";
            $extra_params[':transmission'] = $params['transmission'];
        }
        if (!empty($params["type_id"])) {
            $basic_querry .= " AND type_id = :type_id";
            $extra_params[':type_id'] = $params['type_id'];
        }
        $basic_querry .= ' ORDER BY ' . $sorting_query;
        $stmt = $pdo->prepare($basic_querry);
        $stmt->execute($extra_params);

        $vehicles = $stmt->fetchAll();

        $response->getBody()->write(json_encode([
            'status' => 'success',
            'data' => $vehicles,
        ], JSON_UNESCAPED_UNICODE));

        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/vehicles', function (Request $request, Response $response) use ($pdo) {

        $data = $request->getParsedBody();

        //check required fields
        if (!isset($data['model_name'], $data['type_id'])) {
            $response->getBody()->write(json_encode([
            'status' => 'error',
            'message'=> 'The fields model_name and type_id are required'
        ]));
        return $response->withHeader('Content-Type', 'application/json') -> withStatus(400);

        }
        //SQL injection protection
        $stmt = $pdo->prepare("
                INSERT INTO vehicles (
                    model_name,
                    type_id,
                    vehicle_type,
                    doors,
                    price,
                    transmission,
                    fuel
                ) VALUES (
                    :model_name,
                    :type_id,
                    :vehicle_type,
                    :doors,
                    :price,
                    :transmission,
                    :fuel
                )
            ");

            $stmt->execute([
                ':model_name'=> $data['model_name'],
                ':type_id'=> $data['type_id'],
                ':vehicle_type'=> $data['vehicle_type'] ?? null,
                ':doors'=> $data['doors'] ?? null,
                ':price'=> $data['price'] ?? null,
                ':transmission'=> $data['transmission'] ?? null,
                ':fuel'=> $data['fuel'] ?? null,
            ]);
        $id = $pdo->lastInsertId();
        $response->getBody()->write(json_encode([
            'status'=>'success, vehicle added.',
            'id'=> $id
        ]));

        return $response
            ->withHeader('Content-Type','application/json')
            ->withStatus(201);
    });


    $app->put('/vehicles/{id}', function (Request $request, Response $response, $args) use ($pdo) {

        $id = $args['id'];
        $data = $request->getParsedBody();

        //check required fields
        if (!isset($data['model_name'], $data['type_id'])) {
            $response->getBody()->write(json_encode([
            'status' => 'error',
            'message'=> 'The fields model_name and type_id are required'
        ]));
        return $response->withHeader('Content-Type', 'application/json') -> withStatus(400);
        }
        //SQL injection protection
        $stmt = $pdo->prepare("
                UPDATE vehicles SET 
                    model_name = :model_name,
                    type_id = :type_id,
                    vehicle_type = :vehicle_type,
                    doors = :doors,
                    price = :price,
                    transmission = :transmission,
                    fuel = :fuel
                WHERE id = :id
            ");

            $stmt->execute([
                ':model_name'=> $data['model_name'],
                ':type_id'=> $data['type_id'],
                ':vehicle_type'=> $data['vehicle_type'] ?? null,
                ':doors'=> $data['doors'] ?? null,
                ':price'=> $data['price'] ?? null,
                ':transmission'=> $data['transmission'] ?? null,
                ':fuel' => $data['fuel'] ?? null,
                ':id' => $id
                
            ]);
        $response->getBody()->write(json_encode([
            'status'=>'success, vehicle changed.',
            'id'=> $id
        ]));

        return $response
            ->withHeader('Content-Type','application/json')
            ->withStatus(200);
    });

    $app->delete('/vehicles/{id}', function (Request $request, Response $response, $args) use ($pdo) {

        $id = $args['id'];
        $data = $request->getParsedBody();
        //SQL injection protection
        $stmt = $pdo->prepare("
                DELETE FROM vehicles 
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $id
            ]);
        if ($stmt->rowCount() === 0) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Vehicle not found, or is already deleted'
            ]));

        return $response
            ->withHeader('Content-Type','application/json')
            ->withStatus(404);
        }
        $response->getBody()->write(json_encode([
            'status'=>'vehicle deleted',
            'id'=> $id
        ]));

        return $response
            ->withHeader('Content-Type','application/json')
            ->withStatus(200);
    });

};