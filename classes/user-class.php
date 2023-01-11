<?php
session_start();
class User{
    public $id;
    public $username;
    public $email;
    public $role_num;
    public $conn;

    function __construct($id_input,$username_input,$email_input,$role_num_input,$conn_input){
        $this->id = $id_input;
        $this->username = $username_input;
        $this->email = $email_input;
        $this->role_num = $role_num_input;
        $this->conn = $conn_input;
    }
    function checkPassword($password){
        $sql = "SELECT id,password,salt,username,role_num FROM users WHERE email = '$this->email'";
        $sqlquery = $this->conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        if (password_verify($row['salt'].$password,$row['password'])){
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role_num'];
            $_SESSION['UID'] = $row['id'];
            $_SESSION['email'] = $this->email;
            header("Location: ../main_page.php");
        }
        else{
            echo "Nooo";
        }
    }
}

?>