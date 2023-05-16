<?php
class Database
{
    public function connect()
    {
        $Database  = new PDO("mysql:host=localhost; dbname=phpwebrtc", "root", "");
        return $Database;
    }
}
