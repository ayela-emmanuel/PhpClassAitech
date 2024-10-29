<?php 

$username = $_GET["username"];

if($_REQUEST["method"] == "POST"){
    $data = file_get_contents("php://input");
    $data = json_decode($data,true);

    echo json_encode($data);
    header("content-type: application/json");
}

