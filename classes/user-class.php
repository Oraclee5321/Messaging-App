<?php

session_start();

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
        $this->username = $username_input;
        $this->email = $email_input;
        $this->role_num = $role_num_input;
        $this->conn = $conn_input;
    }

    function checkPassword($password)
    {
        $sql = "SELECT id,password,salt,username,role_num FROM users WHERE email = '$this->email'";
        $sqlquery = $this->conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        if (password_verify($row['salt'] . $password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role_num'];
            $_SESSION['UID'] = $row['id'];
            $_SESSION['email'] = $this->email;
            header("Location: ../main_page.php");
        } else {
            echo "Nooo";
        }
    }

    function sendMessage($newMessageInput, $conn)
    {
        $messageContent = mysqli_real_escape_string($conn, $newMessageInput);
        $uid = $_SESSION['UID'];
        $sql = "INSERT INTO messages (message_content,user_id) values ('$messageContent','$uid')";
        $sqlquery = $conn->query($sql);
        header("Location: main_page.php");
    }

    function insert($password_input, $salt_input)
    {
        $sql = "INSERT INTO users (username, email, password,role_num,salt) VALUES ('$this->username', '$this->email', '$password_input', '0', '$salt_input')";
        $sqlquery = $this->conn->query($sql);
    }
    
    function editMessage($id,$text,$conn){
        $sql = "UPDATE messages SET message_content = '".$text."' WHERE message_id =".$id."";
        $sqlquery = $conn->query($sql);
        header("Location: main_page.php");
    }

    function deletePost($id,$conn){
        $sql = "DELETE FROM messages WHERE message_id =".$id."";
        $sqlquery = $conn->query($sql);
        header("Location: main_page.php");
    }
}
