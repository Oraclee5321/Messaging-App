<?php
include "messages-class.php";


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

    //Login Functions
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

    function insert($password_input, $salt_input, $conn)
    {
        mysqli_real_escape_string($conn, $password_input);
        $password_input = strip_tags($password_input);
        $salt_input = strip_tags($salt_input);
        $sql = "INSERT INTO users (username, email, password,role_num,salt) VALUES ('$this->username', '$this->email', '$password_input', '0', '$salt_input')";
        $sqlquery = $this->conn->query($sql);
    }
    //End Login Functions

    // Message Functions
    function sendMessage($newMessageInput, $conn)
    {
        $m = new Message($newMessageInput, $this->id, $conn);
        $m->save();
    }
    
    function editMessage($message_id,$text,$conn) {
        $m = Message::getById($message_id,$conn);
        $m->message_content = $text;
        $m->update();
    }

    function deletePost($message_id,$conn){
        $m = Message::getById($message_id,$conn);
        $m->delete();
    }

    function replyMessage($original_message_id,$newMessageInput,$conn)
    {
        $m = new Message($newMessageInput, $this->id, $conn);
        $m->save();
        $m->setReply($original_message_id);
    }
    //End Message Functions

    //User Functions
    function getPfp($conn){
        $sql = "SELECT pfp_image_link FROM users WHERE id = '$this->id'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        return $row['pfp_image_link'];
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

    function changeAvatar($newAvatar,$conn){
        $sql = "SELECT pfp_image_link FROM users WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        if ($row['pfp_image_link'] != "default.png")
        {
            unlink("pfp-pictures/".$row['pfp_image_link']);
        }
        $file_extension = pathinfo($newAvatar['name']);
        $file_extension = $file_extension['extension'];
        $newAvatar['name'] = $this->id.".".$file_extension;
        move_uploaded_file($newAvatar['tmp_name'], "pfp-pictures/".$newAvatar['name']);
        $sql = "UPDATE users SET pfp_image_link = '".$newAvatar['name']."' WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
    }
    function resetAvatar($conn){
        $sql = "SELECT pfp_image_link FROM users WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        unlink("pfp-pictures/".$row['pfp_image_link']);
        $sql = "UPDATE users SET pfp_image_link = 'default.png' WHERE id = '".$this->id."'";
        $sqlquery = $conn->query($sql);
    }
    //End User Functions

    static function getRole($conn,$id){
        $sql = "SELECT role_num FROM users WHERE id = '".$id."'";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        return $row['role_num'];
    }
}

