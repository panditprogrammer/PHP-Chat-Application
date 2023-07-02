<?php

require_once "core/init.php";


// get messages 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['fetch'])) {
    $fromUser = trim(htmlentities($_GET['fromUser']));
    $sendTo = trim(htmlentities($_GET['sendToUser']));


    function size2Byte($size)
    {
        $units = array('KB', 'MB', 'GB', 'TB');
        $currUnit = '';
        while (count($units) > 0  &&  $size > 1024) {
            $currUnit = array_shift($units);
            $size /= 1024;
        }
        return ($size | 0) ." " . $currUnit;
    }


    if (!empty($fromUser) && !empty($sendTo)) {

        $data = $userObject->getMessage($fromUser, $sendTo);
        $messageDataArr = json_decode(json_encode($data), true);

        foreach ($messageDataArr as $key => $value) {

            foreach ($value as $k => $v) {

                if ($k === "message") {

                    $rawMessage = $messageDataArr[$key][$k];
                    $msgArr = explode("!!bin!!", $rawMessage);

                    $data = array("message" => $msgArr[0]);

                    // modify result array and set file info with string message 
                    if (count($msgArr) > 1) {
                        $attachFilePath = "public/images/" . $msgArr[1];
                        $data = array_merge($data, pathinfo($attachFilePath), array("filesize" => size2Byte(filesize($attachFilePath))), array("mimetype" => mime_content_type($attachFilePath)));
                        $messageDataArr[$key]["message"] = $data;
                    } else {
                        $data = array_merge($data, array("filesize" => 0));
                        $messageDataArr[$key]["message"] = $data;
                    }
                    $messageDataArr[$key][$k] = $data;
                }
            }
        }

        echo json_encode($messageDataArr);
    } else {
        echo "0";
    }

    return;
}

// update user last seen 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['timeStamp'])) {


    $fromUser = trim(htmlentities($_GET['fromUser']));
    $timeStamp = trim(htmlentities($_GET['timeStamp']));

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

    $fromUser = trim(htmlentities($_GET['fromUser']));
    $sendTo = trim(htmlentities($_GET['sendTo']));
    $status = trim(htmlentities($_GET['status']));

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

    $fromUser = trim(htmlentities($_GET['fromUser']));
    $sendTo = trim(htmlentities($_GET['sendTo']));

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

    $userId = trim(htmlentities($_GET['userId']));

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

    $fromUser = trim(htmlentities($_POST['fromUser']));
    $sendTo = trim(htmlentities($_POST['sendToUser']));
    $message = trim(htmlentities($_POST['message']));

    $attachment = $_FILES['attachment'];

    if ($attachment['error'] === 0) {

        $fileName = time() . "_" . $attachment['name'];
        $message .= "!!bin!!" . $fileName;
        // upload attach file 
        move_uploaded_file($attachment['tmp_name'], "public/images/" . $fileName);
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
