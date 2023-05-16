<?php
require_once "core/init.php";
if (!$userObject->isLoggedIn()) {
    $userObject->redirect("login.php");
}

$userObject->logout();
