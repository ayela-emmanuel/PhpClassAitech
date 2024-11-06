<?php
const db_host = "localhost";
const db_user = "root";
const db_password = "";
const db_name = "shopper_vision";
const DB = new mysqli(db_host,db_user,db_password,db_name);
if(DB->errno < 0){
    die("Error Connecting To DB");
}

?>