<?php
//require('Database.php');
class Account
{
    private $id;
    private $username;
    private $email;
    private $role;
    private const TABLENAME = "accounts";
   
    function __construct()
    {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->role = 1;
    }
    
    public function GetAccountByUsername($username)
    { 

        $columns = array("id","username","email","role");
        $parameters = array($username);
        $db = Database::getInstance();

        $con = $db->getConnection();
        $columns = Database::Select("SELECT", $columns, $parameters, self::TABLENAME, "WHERE username = ?");
        $this->id = $columns[0];
        $this->username = $columns[1];
        echo "|"."$this->id"." - "."$username";
        return 0;
    }
}
?>