<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/customers', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode(['message' => "Get All Customers 😁😁🫣!" , 'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

?>