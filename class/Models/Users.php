<?php

class Users
{
    private $Result;
    private $Error;

    public function __construct(
        private $Name,
        private $UserName,
        private $ZipCode,
        private $Email,
        private $Password
    ) {
    }

    public function Insert()
    {
        $insert = new Insert();
        $insert->Exec("usuarios", ["name" => $this->Name, "userName" => $this->UserName, "zipCode" => $this->ZipCode, "email" => $this->Email, "password" => $this->Password]);
        $this->Result = $insert->GetResult();
        $this->Error = $insert->GetError();
    }

    public static function ReturnUsers()
    {
        $select = new Select();
        return $select->Exec("SELECT * FROM usuarios ORDER BY name ASC");
    }

    public static function ReturnUser($email)
    {
        $select = new Select();
        return $select->Exec("SELECT * FROM usuarios WHERE email = :E", [":E" => $email]);
    }

    public function GetResult()
    {
        return $this->Result;
    }

    public function GetError()
    {
        return $this->Error;
    }
}
