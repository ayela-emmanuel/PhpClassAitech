<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;



require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
const latte = new Latte\Engine;
const templates_dir = __DIR__."/views/";



$app->get('/', Routes\HomeController::class);
$app->get('/bye', Routes\HomeController::class);
$app->get("/about",Routes\AboutController::class);
$app->get("/contact",Routes\ContactController::class. ":Index");
$app->get("/contact_email",Routes\ContactController::class. ":ContactEmail");


$app->run();