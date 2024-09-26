<?php 

namespace App\Models;

use AyelaORM\DatabaseObject;
use AyelaORM\SQLType;

class User extends DatabaseObject{
    #[SQLType("VARCHAR(100)")]
    public string $db_UserName;
    #[SQLType("VARCHAR(100)")]
    public string $db_Email;
    #[SQLType("VARCHAR(255)")]
    public string $db_PasswordHash;
}



?>