<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

$userObject = new User;


define("ROOT_URL","/callme/");
define("SITE_NAME" , "Ignite Text");