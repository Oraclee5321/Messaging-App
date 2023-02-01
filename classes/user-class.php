<?php


class User
{
    public $id;
    public $username;
    public $email;
    public $role_num;
    public $conn;

    function __construct($id_input, $username_input, $email_input, $role_num_input, $conn_input)
    {
        $this->id = $id_input;
        $this->username = strip_tags(strval($username_input));
        $this->email = strip_tags($email_input);
        $this->role_num = $role_num_input;
        $this->conn = $conn_input;
    }

    function getPfp($conn){
        $sql = "SELECT pfp_image_link FROM users WHERE id = '$this->id'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        return $row['pfp_image_link'];
    }
    function checkPassword($password)
    {
        $sql = "SELECT id,password,salt,username,role_num FROM users WHERE email = '$this->email'";
        $sqlquery = $this->conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        $temp = password_verify($row['salt'] . $password, $row['password']);
        if (password_verify($row['salt'] . $password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role_num'];
            $_SESSION['UID'] = $row['id'];
            $_SESSION['email'] = $this->email;
            header("Location: ../main_page.php");
        } else {
            $_SESSION['error'] = "Incorrect password and/or email";
            header("Location: ../index.php");
        }
    }

    function sendMessage($newMessageInput, $conn)
    {
        $messageContent = mysqli_real_escape_string($conn, $newMessageInput);
        $messageContent = strip_tags($messageContent, '<br>');
        $uid = $_SESSION['UID'];
        $sql = "INSERT INTO messages (message_content,user_id) values ('$messageContent','$uid')";
        $sqlquery = $conn->query($sql);
    }

    function insert($password_input, $salt_input, $conn)
    {
        mysqli_real_escape_string($conn, $password_input);
        $password_input = strip_tags($password_input);
        $salt_input = strip_tags($salt_input);
        $sql = "INSERT INTO users (username, email, password,role_num,salt) VALUES ('$this->username', '$this->email', '$password_input', '0', '$salt_input')";
        $sqlquery = $this->conn->query($sql);
    }
    
    function editMessage($id,$text,$conn){
        $text = strip_tags($text, '<br>');
        $sql = "UPDATE messages SET message_content = '".$text."' WHERE message_id =".$id."";
        $sqlquery = $conn->query($sql);
    }

    function deletePost($id,$conn){
        $sql = "DELETE FROM messages WHERE message_id =".$id."";
        $sqlquery = $conn->query($sql);
    }
    function getRoleName(){
        if ($this->role_num == 0){
            return "User";
        }
        else if ($this->role_num == 1){
            return "Admin";
        }
        else if ($this->role_num == 2){
            return "Super Admin";
        }
    }
    function changeUsername($newUsername,$conn){
        $this->username = $newUsername;
        $sql = "UPDATE users SET username = '".$this->username."' WHERE email = '".$this->email."'";
        $sqlquery = $conn->query($sql);
        $_SESSION['username'] = $this->username;

    }
    function changeEmail($newEmail,$conn){
        $this->email = $newEmail;
        $sql = "UPDATE users SET email = '".$this->email."' WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
        $_SESSION['email'] = $this->email;
    }
    function deleteUserAdmin($conn){
        $sql = "DELETE FROM users WHERE id =".$this->id."";
        $sqlquery = $conn->query($sql);
    }
    function replyMessage($id,$text,$conn){
        $text = strip_tags($text);
        $sql = "INSERT INTO messages (message_content,user_id) values ('$text','$this->id')";
        $sqlquery = $conn->query($sql);
        $sql = "UPDATE messages SET has_reply = 1 WHERE message_id =".$id."";
        $sqlquery = $conn->query($sql);
        $sql = "SELECT message_id FROM messages WHERE user_id =".$this->id." ORDER BY message_id DESC LIMIT 1 ";
        $sqlquery = $conn->query($sql);
        $newId = $sqlquery->fetch_assoc();
        $sql = "INSERT INTO replies (message_id, new_message_id) values ('$id','$newId[message_id]')";
        $sqlquery = $conn->query($sql);

    }
    function changeAvatar($newAvatar,$conn){
        $sql = "SELECT pfp_image_link FROM users WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        unlink("pfp-pictures/".$row['pfp_image_link']);
        $file_extension = pathinfo($newAvatar['name']);
        $file_extension = $file_extension['extension'];
        $newAvatar['name'] = $this->id.".".$file_extension;
        move_uploaded_file($newAvatar['tmp_name'], "pfp-pictures/".$newAvatar['name']);
        $sql = "UPDATE users SET pfp_image_link = '".$newAvatar['name']."' WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
    }

    static function getRole($conn,$id){
        $sql = "SELECT role_num FROM users WHERE id = '".$id."'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        return $row['role_num'];
    }
}

