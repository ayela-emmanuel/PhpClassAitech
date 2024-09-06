<?php


$input =  file_get_contents("php://input");

$data = json_decode($input,true);
var_dump($data );
?>