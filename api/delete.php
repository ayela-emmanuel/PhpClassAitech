<?php
include "../datacontext.php";

if(!isset($_GET["index"])){
    die;
}

$index =$_GET["index"];
print($index);
DeleteProduct($index);
?>