<?php

use App\Models\User;
use AyelaORM\Database;
use Latte\Engine;
include __DIR__."/vendor/autoload.php"; 
require_once __DIR__.'/router.php';

$env = \Dotenv\Dotenv::createImmutable(__DIR__);
$env->load();


Database::setup($_ENV["DB_HOST"],$_ENV["DB_NAME"],$_ENV["DB_USERNAME"],$_ENV["DB_PASSWORD"],false);


$user = new User();
// $user->db_UserName = "Test User";
// $user->db_Email = "a@gmail.com";
// $user->db_PasswordHash = "1234567890";
// $user->save();


$latte = new Engine();
//Register Route
get("/","/src/views/home.php");
get("/jewellery","/src/views/jewellery.php");
get("/about","/src/views/about.php");
get("/auth","/src/views/auth.php");
any("/auth","/src/views/auth.php");
get("/dashboard",function (){
    echo "Welcome";
});



?>