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

                print('<li class="' . $active . '">
                        <a href="' . ROOT_URL . $user->username . '">
                            <div class="d-flex">
                                <div class="chat-user-img online align-self-center me-3 ms-0">
                                    <img src="assets/images/users/' . ($user->profileImg ? $user->profileImg : "default-user.png") . '" class="rounded-circle avatar-xs" alt="">
                                    <span class="user-status"></span>
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="text-truncate font-size-15 mb-1">' . ($user->name ? $user->name : $user->username) . '</h5>
                                    <p class="chat-user-message text-truncate mb-0">Hey! there I\'m available</p>
                                </div>
                                <div class="font-size-11">05 min</div>
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
                                    <span class="user-status"></span>
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
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
