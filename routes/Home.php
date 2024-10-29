<?php
namespace Routes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Home{
    public function __invoke(Request $request, Response $response, $args) {
        $response->getBody()->write("HomePage");
        return $response;
    }
}





