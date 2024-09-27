<?php 

namespace App\Models;

use AyelaORM\DatabaseObject;
use AyelaORM\SQLIgnore;
use AyelaORM\SQLType;

class User extends DatabaseObject{
    #[SQLType("VARCHAR(100)")]
    public string $UserName;
    #[SQLType("VARCHAR(100)")]
    public string $Email;
    #[SQLType("VARCHAR(255)")]
    public string $PasswordHash;

}



?>