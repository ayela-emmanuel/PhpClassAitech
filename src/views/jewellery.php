<?php
use LATTE\Engine;
include __DIR__."/../../vendor/autoload.php";


$latte = new Engine();
$latte->render("templates/jewellery.latte",[
    "data"=> "hello"
]);
