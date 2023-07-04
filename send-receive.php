<?php

require_once "core/init.php";


// get messages 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['fetch'])) {
    $fromUser = $userObject->getSafeValue($_GET['fromUser']);
    $sendTo = $userObject->getSafeValue($_GET['sendToUser']);


    function size2Byte($size)
    {
        $units = array('KB', 'MB', 'GB', 'TB');
        $currUnit = null;
        while (count($units) > 0  &&  $size > 1024) {
            $currUnit = array_shift($units);
            $size /= 1024;
        }
        if (!$currUnit)
            $currUnit = "Bytes";
        return ($size | 0) . " " . $currUnit;
    }

    if (!empty($fromUser) && !empty($sendTo)) {
        echo json_encode($userObject->getMessage($fromUser, $sendTo));
    } else {
        echo "0";
    }

    return;
}

// update user last seen 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['timeStamp'])) {


    $fromUser = $userObject->getSafeValue($_GET['fromUser']);
    $timeStamp = $userObject->getSafeValue($_GET['timeStamp']);

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

    $fromUser = $userObject->getSafeValue($_GET['fromUser']);
    $sendTo = $userObject->getSafeValue($_GET['sendTo']);
    $status = $userObject->getSafeValue($_GET['status']);

    if (!empty($fromUser) && !empty($sendTo)) {
        $userObject->updateStatus($fromUser, $sendTo, $status);
        echo "true";
    } else {
        echo "false";
    }
    return;
}

// get user activities
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['getActivity'])) {

    $fromUser = $userObject->getSafeValue($_GET['fromUser']);
    $sendTo = $userObject->getSafeValue($_GET['sendTo']);

    if (!empty($fromUser) && !empty($sendTo)) {
        $userStatus = $userObject->getStatus($sendTo, $fromUser);
        $userLastSeen = $userObject->getLastSeen($sendTo);

        $arr0 =  $userStatus ? $userStatus : [];
        $arr1 =  $userLastSeen ? $userLastSeen : [];

        echo json_encode(array_merge($arr0, $arr1));
    } else {
        echo "false";
    }
    return;
}

// get single user last seen
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['checkLastSeen'])) {

    $userId = $userObject->getSafeValue($_GET['userId']);

    if (!empty($userId)) {
        $lastSeen = $userObject->getLastSeen($userId);
        echo json_encode($lastSeen ?  $lastSeen : []);
    } else {
        echo "false";
    }
    return;
}

// post methods 
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)) {

    $fromUser = $userObject->getSafeValue($_POST['fromUser']);
    $sendTo = $userObject->getSafeValue($_POST['sendToUser']);
    $message = $userObject->getSafeValue($_POST['message']);

    $attachment = $_FILES['attachment'];

    if ($attachment['error'] === 0) {
        $fileName = time() . "_" . $attachment['name'];
        $message .= "!!bin!!" . $fileName;
        // upload attach file 
        move_uploaded_file($attachment['tmp_name'], "public/files/" . $fileName);
    }


    if (!empty($fromUser) && !empty($sendTo) && !empty($message)) {

        if ($userObject->saveMessage($fromUser, $sendTo, $message)) {
            echo "1";
        } else {
            echo "0";
        }
    }
    return;
}



if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['messageId']) && $_GET['messageId'] > 0) {

    if ($userObject->deleteMessage($_GET['messageId'])) {
        echo "true";
    } else {
        echo "false";
    }
}
