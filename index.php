<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/projects/restful_api');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
require __DIR__ . '/utils/connect_db.php';
require __DIR__ . '/routers/authentication.php';
require __DIR__ . '/routers/customers.php';
require __DIR__ . '/routers/employees.php';
require __DIR__ . '/routers/products.php';
require __DIR__ . '/services/customers.php';
require __DIR__ . '/services/employees.php';
require __DIR__ . '/services/products.php';
require __DIR__ . '/services/authentication.php';



$dotenv->load();


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode([
        'message' => "Welcome to my api end point 😁😁🫣!" , 'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});

$app->run()


?>