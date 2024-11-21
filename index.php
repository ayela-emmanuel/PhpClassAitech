<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require __DIR__ . '/vendor/autoload.php';

require_once __DIR__."/includes/connection.php";
require_once __DIR__."/includes/constants.php";
session_start();

$app = AppFactory::create();
const latte = new Latte\Engine;
const templates_dir = __DIR__."/views/";



$app->get('/', Routes\HomeController::class);
$app->get('/dashboard', Routes\DashboardController::class);
$app->get("/about",Routes\AboutController::class);
$app->get("/contact",Routes\ContactController::class. ":Index");
$app->get("/auth",Routes\AuthController::class. ":Index");
$app->post("/auth",Routes\AuthController::class. ":FormSubmitted");
$app->get("/logout",Routes\AuthController::class. ":Logout");

$app->get("/contact_email",Routes\ContactController::class. ":ContactEmail");


///Products
$app->post("/api/products/update",Routes\ProductsController::class. ":Create");
$app->post("/api/products/create",Routes\ProductsController::class. ":Create");
$app->delete("/api/products/delete",Routes\ProductsController::class. ":Delete");
$app->get("/api/products/all",Routes\ProductsController::class. ":GetAll");
$app->get("/api/products/my",Routes\ProductsController::class. ":MyProducts");






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