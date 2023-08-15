<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use Service\ProductService;

$app->get('/products', function (Request $request, Response $response, $args) {
    $prod_srv = new ProductService($GLOBALS['conn']);
    $result = $prod_srv->getAllProducts();
    $response->getBody()->write(json_encode([
        'message' => "Get All Products 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});


$app->get('/product/{productCode}', function (Request $request, Response $response, $args) {
    $productCode = $args['productCode'];
    $prod_srv = new ProductService($GLOBALS['conn']);
    $result = $prod_srv->getProductById($productCode);
    $response->getBody()->write(json_encode([
        'message' => "Get Product By Id 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

$app->post('/product', function (Request $request, Response $response, $args) {
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $prod_srv = new ProductService($GLOBALS['conn']);
    $result = $prod_srv->insertProduct($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Insert Product 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

$app->put('/product/{productCode}', function (Request $request, Response $response, $args) {
    $productCode = $args['productCode'];
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $prod_srv = new ProductService($GLOBALS['conn']);
    $result = $prod_srv->updateProductById($productCode,$bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Update Product 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});


$app->delete('/product', function (Request $request, Response $response, $args) {
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $prod_srv = new ProductService($GLOBALS['conn']);
    $result = $prod_srv->deleteProductById($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Delete Product 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});





?>