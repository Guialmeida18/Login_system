<?php

include_once "./vendor/autoload.php";

use App\Infra\Database\Connector;
use App\Infra\UseCases\LoginUseCase;

$connector = new Connector("root", "1234", "login_sistema", "mysql" );
$loginUseCase = new LoginUseCase($connector);
 function returnResponse($data, $code)
{
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($code);
    echo json_encode($data);
}

$requestUri = $_SERVER['REQUEST_URI'];
 $uriSegments = explode("?", $requestUri);
 $uri = array_shift($uriSegments);

 $uriSegments = str_replace('id=', '', $uriSegments);

 $route = [
     "/list" => ["method" => 'GET', 'action' => 'list'],
     "/edit" => ["method" => 'PUT', 'action' => 'edit'],
     "/delete" => ["method" => 'DELETE', 'action' => 'delete'],
     "/find" => ["method" => 'GET', 'action' => 'find'],
     "/create" => ["method" => 'POST', 'action' => 'create'],
 ];

$route = $route[$uri] ?? null;

 if ($route) {
     switch ($route['action']){
         case "list":
             returnResponse($loginUseCase->list(), 200);
             break;

         case "edit":
             $data = file_get_contents("php://input");
             parse_str($data , $params);
           returnResponse($loginUseCase->edit($uriSegments[0], $params), 200);
             break;

         case "delete":
             returnResponse($loginUseCase->delete($uriSegments[0]), 200);
             break;

         case "find":
             returnResponse($loginUseCase->find($uriSegments[0]), 200);
             break;

         case "create":

            returnResponse($loginUseCase->create($_POST), 200);
             break;
     }
 } else {
     returnResponse([], 404);
     die("404 not Found");
 }