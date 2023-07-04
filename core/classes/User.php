<?php

namespace MyApp;

use PDO;
use PDOException;

class User
{
    public  $db, $userId, $sessionId;
    public function __construct()
    {
        $db = new Database();
        try {
            $this->db = $db->connect();
        } catch (PDOException) {
            die("Database connection Failed!");
        }

        $this->userId = $this->getId();
        $this->sessionId = $this->getSessionId();
    }

    public function getId()
    {
        if ($this->isLoggedIn()) {
            return $_SESSION['userId'];
        }
    }

    // return logged in session id 
    public function getSessionId()
    {
        return session_id();
    }

    public function emailExist($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public function registerUser($email, $username, $password)
    {
        $password = $this->hash($password);
        $current_timestamp = date("Y-m-d H:i:s");
        $stmt = $this->db->prepare("INSERT INTO users (email,username,password,created_on) VALUES (:email,:username,:password,:created_on)");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":created_on", $current_timestamp, PDO::PARAM_STR);

        return $stmt->execute();

        return $stmt->execute();
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function redirect($location)
    {
?>
        <script>
            location.href = "<?php echo $location; ?>";
        </script>
<?php
    }


    public function getSafeValue($string)
    {
        return trim(htmlentities($string));
    }


    public function getUserById($userId = null)
    {
        $userId = ((!empty($userId)) ? $userId : $this->userId);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function isLoggedIn()
    {
        return ((isset($_SESSION['userId'])) ? true : false);
    }

    public function logout()
    {
        $_SESSION = array();
        session_regenerate_id();
        session_destroy();
        $this->redirect("login.php");
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id != :id");
        $stmt->bindParam(":id", $this->userId, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($users) {
            foreach ($users as $user) {

                if (isset($_GET['username']) && $_GET['username'] === $user->username) {
                    $active = "active";
                } else {
                    $active = null;
                }

                $dateFormat = date("d/m/Y", strtotime($user->last_seen));
                $timeFormat = date("H:i", strtotime($user->last_seen));

                $today = date("d/m/Y");
                $yestarday = date("d/m/Y", strtotime("yesterday"));

                if ($dateFormat === $today) {
                    $last_seen = "Today $timeFormat";
                } else if ($dateFormat === $yestarday) {
                    $last_seen = "Yestarday $timeFormat";
                } else {
                    $last_seen = $timeFormat . " " . $dateFormat;
                }




                print('<li class="' . $active . '">
                        <a href="' . ROOT_URL . $user->username . '">
                            <div class="d-flex">
                                <div class="chat-user-img online align-self-center me-3 ms-0">
                                    <img src="assets/images/users/' . ($user->profileImg ? $user->profileImg : "default-user.png") . '" class="rounded-circle avatar-xs" alt="">
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="text-truncate font-size-15 mb-1">' . ($user->name ? $user->name : $user->username) . '</h5>
                                    <p class="chat-user-message text-truncate mb-0">Hey! there I\'m available</p>
                                </div>
                                <div class="font-size-11">' . ($last_seen) . '</div> 
                            </div>
                        </a>
                    </li>');
            }
        } else {
            print('<li>
                        <a href="">
                            <div class="d-flex">
                                <div class="chat-user-img online align-self-center me-3 ms-0">
                                    <img src="assets/images/users/default-user.png" class="rounded-circle avatar-xs" alt="">
                                    <span class="user-status" style="background-color: black;"></span>
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="text-truncate font-size-15 mb-1"> No Users!</h5>
                                    <p class="chat-user-message text-truncate mb-0">Sorry! user isn\'t available</p>
                                </div>
                                <div class="font-size-11">05 min</div>
                            </div>
                        </a>
                 </li>');
        }
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateSession()
    {
        $stmt = $this->db->prepare("UPDATE users SET sessionId = :sessionId , updated_on = :updated_on WHERE id = :id");
        $stmt->bindParam(":sessionId", $this->sessionId, PDO::PARAM_STR);
        $stmt->bindParam(":updated_on", $current_timestamp, PDO::PARAM_STR);
        $stmt->bindParam(":id", $this->userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateConnection($connectionId, $userId)
    {
        $current_timestamp = date("Y-m-d H:i:s");
        $stmt = $this->db->prepare("UPDATE users SET connectionId = :connectionId , updated_on = :updated_on WHERE id = :id");
        $stmt->bindParam(":connectionId", $connectionId, PDO::PARAM_STR);
        $stmt->bindParam(":updated_on", $current_timestamp, PDO::PARAM_STR);
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUserBySession($sessionId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE sessionId = :sessionId");
        $stmt->bindParam(":sessionId", $sessionId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    // get message from user chat 
    public function getMessage($fromUser, $sendTo)
    {
        $stmt = $this->db->prepare("SELECT chatting.* FROM chatting WHERE chatting.fromUser = :fromUser AND chatting.sendTo = :sendTo OR  chatting.fromUser = :sendTo AND chatting.sendTo = :fromUser");
        $stmt->bindParam(":fromUser", $fromUser, PDO::PARAM_INT);
        $stmt->bindParam(":sendTo", $sendTo, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        $messageDataArr = json_decode(json_encode($data), true);
        foreach ($messageDataArr as $key => $value) {

            foreach ($value as $k => $v) {

                if ($k === "message") {

                    $rawMessage = $messageDataArr[$key][$k];
                    $msgArr = explode("!!bin!!", $rawMessage);

                    $data = array("message" => html_entity_decode($msgArr[0]));

                    // modify result array and set file info with string message 
                    if (count($msgArr) > 1) {
                        $attachFilePath = "public/files/" . $msgArr[1];
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

        return $messageDataArr;
    }

    // checking numm of message 
    private function getMessageRowsNum($fromUser, $sendTo)
    {
        $stmt = $this->db->prepare("SELECT count(id) as numOfMsg FROM chatting WHERE fromUser = :fromUser AND sendTo = :sendTo");
        $stmt->bindParam(":fromUser", $fromUser, PDO::PARAM_INT);
        $stmt->bindParam(":sendTo", $sendTo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_NUM);
    }

    public function saveMessage($fromUser, $sendTo, $message)
    {
        // only for first time 
        $result = $this->getMessageRowsNum($fromUser, $sendTo);
        if ($result[0] === 0) {
            $this->initializeActivities($fromUser, $sendTo);
        }

        $current_timestamp = date("Y-m-d H:i:s");
        $stmt = $this->db->prepare("INSERT INTO chatting (fromUser,sendTo,message,created_on) VALUES (:fromUser,:sendTo,:message,:created_on)");
        $stmt->bindParam(":fromUser", $fromUser, PDO::PARAM_STR);
        $stmt->bindParam(":sendTo", $sendTo, PDO::PARAM_STR);
        $stmt->bindParam(":message", $message, PDO::PARAM_STR);
        $stmt->bindParam(":created_on", $current_timestamp, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // get single message 
    public function getSingleMessage($messageId)
    {
        $stmt = $this->db->prepare("SELECT * FROM chatting WHERE id = :id");
        $stmt->bindParam(":id", $messageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // delete message 
    public function deleteMessage($messageId)
    {
        $rawMessage = $this->getSingleMessage($messageId);
        $msgArr = explode("!!bin!!", $rawMessage['message']);

        // delete file 
        if (count($msgArr) > 1) {
            $attachFilePath = "public/files/" . $msgArr[1];
            if (file_exists($attachFilePath)) {
                unlink($attachFilePath);
            }
        }

        $stmt = $this->db->prepare("DELETE FROM chatting WHERE id = :id");
        $stmt->bindParam(":id", $messageId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateLastSeen($userId, $timestamp)
    {
        $stmt = $this->db->prepare("UPDATE users SET last_seen = :last_seen WHERE id = :userId");
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":last_seen", $timestamp, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateStatus($fromUser, $sendTo, $status)
    {
        $stmt = $this->db->prepare("UPDATE activities SET status = :status WHERE fromUser = :fromUser AND sendTo = :sendTo");
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":fromUser", $fromUser, PDO::PARAM_INT);
        $stmt->bindParam(":sendTo", $sendTo, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getStatus($fromUser, $sendTo)
    {
        $stmt = $this->db->prepare("SELECT status FROM activities WHERE fromUser = :fromUser AND sendTo = :sendTo");
        $stmt->bindParam(":fromUser", $fromUser, PDO::PARAM_INT);
        $stmt->bindParam(":sendTo", $sendTo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastSeen($userId)
    {
        $stmt = $this->db->prepare("SELECT last_seen FROM users WHERE users.id = :userId");
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    private function initializeActivities($fromUser, $sendTo)
    {
        $current_timestamp = date("Y-m-d H:i:s");
        $stmt = $this->db->prepare("INSERT INTO activities (fromUser,sendTo,created_on) VALUES (:fromUser,:sendTo,:created_on)");
        $stmt->bindParam(":fromUser", $fromUser, PDO::PARAM_INT);
        $stmt->bindParam(":sendTo", $sendTo, PDO::PARAM_INT);
        $stmt->bindParam(":created_on", $current_timestamp, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
