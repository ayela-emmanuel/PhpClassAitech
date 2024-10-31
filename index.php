<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Routes\About;
use Routes\Home;
use Slim\Factory\AppFactory;



require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
const latte = new Latte\Engine;
const templates_dir = __DIR__."/views/";



$app->get('/', Home::class);
$app->get('/bye', Home::class);

$app->get("/about",About::class);


$app->run();