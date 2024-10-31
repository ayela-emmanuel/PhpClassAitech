<?php
namespace Routes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Home{
    public function __invoke(Request $request, Response $response, $args) {
        echo latte->renderToString(templates_dir.'template.latte',[
            "someData"=>"We Are Here"
        ]);
        //$response->getBody()->write($output);
        return $response;
    }
}





