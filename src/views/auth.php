<?php

use App\Models\User;
use LATTE\Engine;
include __DIR__."/../../vendor/autoload.php";

$username = $_POST["username"] ?? null;
$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;
$error= null;
if(isset($_POST["Register"])){
    // Registering
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $user_ = User::getBy("Email",$email);
        if(count($user_) == 0){
            $user = new User();
            $user->UserName = $username;
            $user->Email = $email;
            $user->PasswordHash = password_hash($password,PASSWORD_DEFAULT);
            $user->save();
        }else{
            $error = "The Email $email Already Used";
        }
        
    }else{
        $error = "Email Not Valid";
    }
    
}





if(isset($_POST["Login"])){
    // Logging in 
    $user = User::getBy("UserName",$username)[0] ?? null;
    if($user == null){
        $error = "Credentials Not Found";
    }else{
        if(password_verify($password, $user->PasswordHash)){
            session_start();
            $_SESSION["user"] = $user;
            header("Location: dashboard");
            die;
        }else{
            $error = "Incorrect Password";
        }
    }
}




$latte = new Engine();
$latte->render("templates/auth.latte",[
    "error" => $error
]);
