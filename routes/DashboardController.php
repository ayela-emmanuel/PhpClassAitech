<?php
namespace Routes;

use App\Models\UserModel;
use App\PageModels\HomePageModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class DashboardController{
    private string $DashboardTemplate = templates_dir.'seller.latte';



    public $data;
    public function __invoke(Request $request, Response $response, $args) {
        ///if not loggedin goto auth
        if(!isset($_SESSION["User"])){
            $response = $response->withHeader("Location", "/auth")->withStatus(302);
            return $response;
        }else if($_SESSION["User"]["role"] != "seller"){
            $response = $response->withHeader("Location", "/auth")->withStatus(302);
            return $response;
        }

        $output = latte->renderToString($this->DashboardTemplate,
        $this);
        $response->getBody()->write($output);
        return $response;
    }
}





