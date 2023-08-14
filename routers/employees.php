<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/employees', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode(['message' => "Get All Employees 😁😁🫣!" , 'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});


?>