<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require __DIR__ . '/vendor/autoload.php';

require_once __DIR__."/includes/connection.php";
require_once __DIR__."/includes/constants.php";

$app = AppFactory::create();
const latte = new Latte\Engine;
const templates_dir = __DIR__."/views/";



$app->get('/', Routes\HomeController::class);
$app->get('/bye', Routes\HomeController::class);
$app->get("/about",Routes\AboutController::class);
$app->get("/contact",Routes\ContactController::class. ":Index");
$app->get("/auth",Routes\AuthController::class. ":Index");
$app->post("/auth",Routes\AuthController::class. ":FormSubmitted");
$app->get("/contact_email",Routes\ContactController::class. ":ContactEmail");







$app->get("/users/list",function (Request $req, Response $res){
    header("content-type: application/json");
    $result = DB->query("INSERT INTO `users` 
    (`fullname`,`username`,`phone`,`password`,`role`) 
    VALUES
    ('emmanuel', 'sammy', '+234534567', '1234567890', 'user')
    ");



    $data = [
        "result"=> $result != false
    ];
    

    $res->getBody()->write(json_encode($data));

    return $res;
});



$app->run();