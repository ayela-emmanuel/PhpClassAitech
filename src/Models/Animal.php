<?php 

namespace App\Models;

use AyelaORM\DatabaseObject;
use AyelaORM\SQLType;


class Animal extends DatabaseObject{
    #[SQLType("VARCHAR(100)")]
    public string $db_Name;
    #[SQLType("VARCHAR(100)")]
    public string $db_Breed;
    #[SQLType("VARCHAR(30)")]
    public string $db_Color;
    #[SQLType("INT(1)")]
    public int $db_Gender;
    #[SQLType("INT(3)")]
    public int $db_Age;
}



?>