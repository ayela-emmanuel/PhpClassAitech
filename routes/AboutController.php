<?php
namespace Routes;

use App\Models\UserModel;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

class AboutController{
    public function __invoke(Request $request, Response $res)
    {
        $out = latte->renderToString('views/template.latte',
        [
            "user"=> new UserModel()
        ]);
        $res->getBody()->write($out);
        return $res;
    }
}




?>