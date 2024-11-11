<?php

namespace Routes;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthController{

    protected $container;
    private string $AuthTemplate = templates_dir.'auth.latte';
    
    public ?string $Message = "";


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
        $FilterPassed = true;
        $FullName = $data["FullName"] ?? null;
        $UserName = $data["UserName"] ?? null;
        $Email = $data["Email"] ?? null;
        $Phone = $data["Phone"] ?? null;
        $Password = $data["Password"] ?? null;
        


        
        


        $isValidFullName = preg_match(FullNameValidationPattern, $FullName);
        $isValidUserName = preg_match(UserNameValidationPattern, $UserName);
        $isValidPhone = preg_match(PhoneValidationPattern, $Phone);
        $isValidPassword = preg_match(PasswordValidationPattern, $Password);
        if(!filter_var($Email,FILTER_VALIDATE_EMAIL)){
            $this->Message .= "Invalid Email";
            $FilterPassed = false;
        }
        if(!$isValidFullName){
            $this->Message .= "Invalid Full Name, ";
            $FilterPassed = false;
        }
        if(!$isValidUserName){
            $this->Message .= "Invalid Username, ";
            $FilterPassed = false;
        }
        if(!$isValidPhone){
            $this->Message .= "Invalid Phone Number, ";
            $FilterPassed = false;
        }
        if(!$isValidPassword){
            $this->Message .= "Invalid Password, Your Password requires at least one uppercase letter, one lowercase letter, one number, and one special character, with a minimum length of 8 characters";
            $FilterPassed = false;
        }


        $query = "INSERT INTO `users` 
            (`fullname`,`username`,`email`,`phone`,`password`,`role`) 
            VALUES
            (?,?,?,?,?,?)
        ";
        if($FilterPassed){
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
        }

        $page = latte->renderToString($this->AuthTemplate,$this);
        $response->getBody()->write($page);
        return $response;
    }



}





?>