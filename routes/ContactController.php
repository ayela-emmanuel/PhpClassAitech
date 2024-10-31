<?php 
namespace Routes;

use Closure;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ContactController{
    protected $container;

   // constructor receives container instance
   public function __construct($container) {
       $this->container = $container;
   }

    public function Index(Request $request,Response $response, $args){
        $response->getBody()->write("Contact Page ");
        return $response;
    }

    public function EmailContact($request, $response, $args){
        $response->getBody()->write("Contact Page Email ");
        return $response;
    }
    

}


?>