<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use Service\CustomerService;


$app->get('/customers', function (Request $request, Response $response, $args) {
    

    $customerNumber = $args['customerNumber'];
    $cos_srv = new CustomerService($GLOBALS['conn']);
    $result = $cos_srv->getAllCustomers();
    $response->getBody()->write(json_encode([
        'message' => "Get ALL Customer 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');


});

$app->get('/customer/{customerNumber}', function (Request $request, Response $response, $args) {
    

    $customerNumber = $args['customerNumber'];
    $cos_srv = new CustomerService($GLOBALS['conn']);
    $result = $cos_srv->getCustomerById($customerNumber);
    $response->getBody()->write(json_encode([
        'message' => "Get Customer By Id 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');


});

$app->get('/customers/search/{keyword}', function (Request $request, Response $response, $args) {
    

    $keyword = $args['keyword'];
    $cos_srv = new CustomerService($GLOBALS['conn']);
    $result = $cos_srv->getAllCustomersBySearch($keyword);
    $response->getBody()->write(json_encode([
        'message' => "Get Customer By Search 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');


});

$app->delete('/customer', function (Request $request, Response $response, $args) {
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $cos_srv = new CustomerService($GLOBALS['conn']);
    $result = $cos_srv->deleteCustomerById($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Delete Customer 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

$app->post('/customer', function (Request $request, Response $response, $args) {
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $cos_srv = new CustomerService($GLOBALS['conn']);
    $result = $cos_srv->insertCustomer($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Insert Customer 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});



$app->put('/customer/{customerNumber}', function (Request $request, Response $response, $args) {
    $customerNumber = $args['customerNumber'];
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $cos_srv = new CustomerService($GLOBALS['conn']);
    $result = $cos_srv->updateCustomerById($customerNumber,$bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Update Customer😁😁🫣!" , 
        'result' =>  $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});
?>