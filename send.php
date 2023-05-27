<?php
require_once "core/init.php";


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST) && $_POST['fetch']) {
    $fromUser = trim(stripcslashes(htmlentities($_POST['fromUser'])));
    $sendTo = trim(stripcslashes(htmlentities($_POST['sendToUser'])));

    if (!empty($fromUser) && !empty($sendTo)) {
        echo json_encode($userObject->getMessage($fromUser, $sendTo));
    } else {
        echo "0";
    }
    return;
}


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {

    $fromUser = trim(stripcslashes(htmlentities($_POST['fromUser'])));
    $sendTo = trim(stripcslashes(htmlentities($_POST['sendToUser'])));
    $message = trim(stripcslashes(htmlentities($_POST['message'])));

    if (!empty($fromUser) && !empty($sendTo) && !empty($message)) {

        if ($userObject->saveMessage($fromUser, $sendTo, $message)) {
            echo "1";
        } else {
            echo "0";
        }
    }
    return;
}
