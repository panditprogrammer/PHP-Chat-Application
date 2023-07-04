<?php

namespace MyApp;

use PDO;

class Database
{

    private $hostname = "localhost";

    private $database = "phpwebrtc";

    private $username = "root";

    private $password = "";

    public function connect()
    {
        $Database  = new PDO("mysql:host=$this->hostname; dbname=$this->database", $this->username, $this->password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ));
        return $Database;
    }
}
