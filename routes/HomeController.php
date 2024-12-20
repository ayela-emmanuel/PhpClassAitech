<?php
namespace Routes;

use App\Models\UserModel;
use App\PageModels\HomePageModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HomeController{
    private string $HomeTemplate = templates_dir.'home.latte';
    public function __invoke(Request $request, Response $response, $args) {
        

        $output = latte->renderToString($this->HomeTemplate,
        $this);
        $response->getBody()->write($output);
        return $response;
    }
}





