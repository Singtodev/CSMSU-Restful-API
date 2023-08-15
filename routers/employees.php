<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Service\EmployeeService;

$app->get('/employees', function (Request $request, Response $response, $args) {

    
    $emp_srv = new EmployeeService($GLOBALS['conn']);
    $result = $emp_srv->getAllEmployees();
    $response->getBody()->write(json_encode([
        'message' => "Get All Employees 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

$app->get('/employee/{employeeNumber}', function (Request $request, Response $response, $args) {

    $employeeNumber = $args['employeeNumber'];
    
    $emp_srv = new EmployeeService($GLOBALS['conn']);
    $result = $emp_srv->getEmployeeById($employeeNumber);
    $response->getBody()->write(json_encode([
        'message' => "Get Employee By Id 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

$app->post('/employee', function (Request $request, Response $response, $args) {

    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $emp_srv = new EmployeeService($GLOBALS['conn']);
    $result = $emp_srv->insertEmployees($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Insert Employee 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');


});


$app->delete('/employee', function (Request $request, Response $response, $args) {

    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $emp_srv = new EmployeeService($GLOBALS['conn']);
    $result = $emp_srv->deleteEmployeeById($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Delete Employee 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');

});


$app->put('/employee/{employeeNumber}', function (Request $request, Response $response, $args) {

    $employeeNumber = $args['employeeNumber'];
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $emp_srv = new EmployeeService($GLOBALS['conn']);
    $result = $emp_srv->updateEmployeeById($employeeNumber,$bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Update Employee 😁😁🫣!" , 
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');

});



?>