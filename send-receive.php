<?php
require_once "core/init.php";


// get messages 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['fetch'])) {
    $fromUser = trim(stripcslashes(htmlentities($_GET['fromUser'])));
    $sendTo = trim(stripcslashes(htmlentities($_GET['sendToUser'])));

    if (!empty($fromUser) && !empty($sendTo)) {
        echo json_encode($userObject->getMessage($fromUser, $sendTo));
    } else {
        echo "0";
    }
    return;
}


// update user last seen 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['timeStamp'])) {


    $fromUser = trim(stripcslashes(htmlentities($_GET['fromUser'])));
    $timeStamp = trim(stripcslashes(htmlentities($_GET['timeStamp'])));

    if (!empty($fromUser) && !empty($timeStamp)) {
        $userObject->updateLastSeen($fromUser, $timeStamp);
        echo "true";
    } else {
        echo "false";
    }
    return;
}

// update user status
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['status'])) {

    $fromUser = trim(stripcslashes(htmlentities($_GET['fromUser'])));
    $status = trim(stripcslashes(htmlentities($_GET['status'])));

    if (!empty($fromUser)) {
        $userObject->updateStatus($fromUser, $status);
        echo "true";
    } else {
        echo "false";
    }
    return;
}

// get user activities
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['getActivity'])) {

    $sendTo = trim(stripcslashes(htmlentities($_GET['sendTo'])));

    if (!empty($sendTo)) {
        echo json_encode($userObject->getUserActivities($sendTo));
    } else {
        echo "false";
    }
    return;
}

// post methods 
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
