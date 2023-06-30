<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

$userObject = new \MyApp\User;


date_default_timezone_set("Asia/Kolkata");
define("ROOT_URL","/callme/");
define("SITE_NAME" , "Ignite Text");