<?php

namespace Routes;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthController{

    protected $container;
    private string $AuthTemplate = templates_dir.'auth.latte';
    
    public ?string $Message = null;


   // constructor receives container instance
   public function __construct($container) {
       $this->container = $container;
   }

    
    public function Index(Request $request,Response $response, $args){
        $page = latte->renderToString($this->AuthTemplate,$this);
        $response->getBody()->write($page);
        return $response;
    }


    public function FormSubmitted(Request $request,Response $response, $args){
        $data = $request->getParsedBody();

        $FullName = $data["FullName"] ?? null;
        $UserName = $data["UserName"] ?? null;
        $Email = $data["Email"] ?? null;
        $Phone = $data["Phone"] ?? null;
        $Password = $data["Password"] ?? null;
        

        $query = "INSERT INTO `users` 
            (`fullname`,`username`,`email`,`phone`,`password`,`role`) 
            VALUES
            (?,?,?,?,?,?)
        ";

        try {
            //prepare our query
            $stmt = DB->prepare($query);
            //execute query with params
            $result = $stmt->execute([
                $FullName,
                $UserName,
                $Email,
                $Phone,
                $Password,
                "user"
            ]);
            //check if qery was executed with no hitch
            if($result){//add messages
                $this->Message = "User Added";
            }else{
                $this->Message = "Failed To Add User";
            }
        } catch (\mysqli_sql_exception $th) {
            $this->Message = "Unknown Error Adding User";
        } catch (\Throwable $th) {
            $this->Message = "Unknown Error Adding User";
        } 
        
        $page = latte->renderToString($this->AuthTemplate,$this);
        $response->getBody()->write($page);
        return $response;
    }



}





?>