<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



$app->get('/authentication', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode(['message' => "Authentication 😁😁🫣!" , 'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});


?>