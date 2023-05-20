<?php

namespace MyApp;

use PDO;


class User
{
    public  $db, $userId, $sessionId;
    public function __construct()
    {
        $db = new Database();
        $this->db = $db->connect();
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

        foreach ($users as $user) {

            if (isset($_GET['username']) && $_GET['username'] === $user->username) {
                $active = "active";
            } else {
                $active = null;
            }

            echo '<li class="' . $active . '">
                        <a href="' . ROOT_URL . $user->username . '">
                            <div class="d-flex">
                                <div class="chat-user-img online align-self-center me-3 ms-0">
                                    <img src="assets/images/users/' . $user->profileImg . '" class="rounded-circle avatar-xs" alt="">
                                    <span class="user-status"></span>
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="text-truncate font-size-15 mb-1">' . $user->name . '</h5>
                                    <p class="chat-user-message text-truncate mb-0">Hey! there I\'m available</p>
                                </div>
                                <div class="font-size-11">05 min</div>
                            </div>
                        </a>
                    </li>';
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
        $stmt = $this->db->prepare("UPDATE users SET sessionId = :sessionId WHERE id = :id");
        $stmt->bindParam(":sessionId", $this->sessionId, PDO::PARAM_STR);
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
}
