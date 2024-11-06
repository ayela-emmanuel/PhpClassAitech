<?php
namespace Routes;

use App\Models\UserModel;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

class AboutController{
    public UserModel $user;
    public function __invoke(Request $request, Response $res)
    {
        $user = new UserModel();


        $out = latte->renderToString('views/template.latte',
        $this);

        
        $res->getBody()->write($out);
        return $res;
    }
}




?>