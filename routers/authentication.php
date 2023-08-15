<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;




use Service\Authentication;

$app->post('/login', function (Request $request, Response $response, $args) {


    try{
        $body = $request->getBody();
        $bodyArray = json_decode($body, true);
        $email = $bodyArray['email'];
        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        $checkRegexEmail = preg_match($pattern, $email);

        $error = false;
        $error_message = "";
        
        if(empty($email) || !$email ){
            $error = true;
            $error_message = "Email is required!";
        }else if(!$checkRegexEmail){
            $error = true;
            $error_message = "Email is wrong!";
        }


        // Check validate examples


        if($error) {

            $response->getBody()->write(json_encode(
                [
                    'message' => $error_message,
                    'status'=> 401
                ]));
            return $response
            ->withStatus(200)    
            ->withHeader('Content-type', 'application/json');
        }

        // Pass continue check query in database Table Employees

        $auth = new Authentication($GLOBALS['conn']);

        $result = $auth->login($bodyArray);



        $response->getBody()->write(json_encode(
            [
                'message' => "Login 😁😁🫣!" ,
                'result' => $result,
                'status'=> 200
        ]));
    
            
        return $response
        ->withStatus(200)    
        ->withHeader('Content-type', 'application/json');
    }catch(err){

        $response->getBody()->write(json_encode(
            [
                'message' => "Something went wrong 😁😁🫣!" ,
                'status'=> 401
            ]));
        return $response
        ->withStatus(200)    
        ->withHeader('Content-type', 'application/json');
    }


});


$app->post('/forgot_password', function (Request $request, Response $response, $args) {
    $body = $request->getBody();
    $bodyArray = json_decode($body, true);
    $auth = new Authentication($GLOBALS['conn']);
    $result = $auth->forgotPassword($bodyArray);
    $response->getBody()->write(json_encode([
        'message' => "Forgot Password 😁😁🫣!" ,
        'result' => $result,
        'status'=> 200]));
    return $response
    ->withStatus(200)    
    ->withHeader('Content-type', 'application/json');
});


?>