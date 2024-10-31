<?php
namespace Routes;

use Slim\Psr7\Response;
use Slim\Psr7\Request;

class AboutController{
    public function __invoke(Request $request, Response $res)
    {
        return $res;
    }
}




?>