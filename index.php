<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Routes\Home;
use Slim\Factory\AppFactory;



require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();



$app->get('/', Home::class);


$app->get('/bye', function (Request $request, Response $response, $args) {
   $response->getBody()->write("bye world!");
   return $response;
});

$app->run();