<?php
use LATTE\Engine;
include __DIR__."/../../vendor/autoload.php";


$latte = new Engine();
$latte->render("templates/homepage.latte",[
    "data"=> "hello"
]);
