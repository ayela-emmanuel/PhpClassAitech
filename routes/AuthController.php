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

    public function Logout(Request $request,Response $response, $args){
        $_SESSION["User"] = null;
        session_destroy();
        $response = $response->withHeader("Location", "/auth")->withStatus(302);
        $response->getBody();
        return $response;
    }



    public function FormSubmitted(Request $request,Response $response, $args){
        $data = $request->getParsedBody();
        if(isset($data["login"])){
            $Email = $data["Email"] ?? null;
            $Password = $data["Password"] ?? "";
            // Get User Data
            $query = "SELECT `id`, `username`, `password`, `role` from `users` WHERE `email` = ?";
            $stmt = DB->prepare($query);
            if($stmt->execute([$Email])){
                $result = $stmt->get_result();
                $userData = $result->fetch_assoc();
                if($userData ){
                    if(password_verify($Password,$userData["password"])){
                        $userData["password"] = null;
                        $_SESSION["User"] = $userData;
                        $response = $response->withHeader("Location", "/dashboard")->withStatus(302);
                    }else {
                        $this->Message = "Incorrect Password";
                    }
                }else{
                    $this->Message = "User Not Found!";
                }
            }else{
                $this->Message = "User Not Found!";
            }
            // Validate Password
            // Save in Session

            $page = latte->renderToString($this->AuthTemplate,$this);
            $response->getBody()->write($page);
            return $response;
        }
        


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
        if(false){
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
                    password_hash($Password, PASSWORD_DEFAULT) ,
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