<?php
    session_start();
    include "db-connection.php";
    $conn = connect();
    class LoginUser{
        public $email;
        public $password;
        public $conn;
        function __construct($email,$password,$conn){
            $this->email = mysqli_real_escape_string($conn,$email);
            $this->password = mysqli_real_escape_string($conn,$password);
            $this->conn = $conn;
        }
        function checkPassword(){
            $sql = "SELECT id,password,salt,username,role_num FROM users WHERE email = '$this->email'";
            $sqlquery = $this->conn->query($sql);
            $row = $sqlquery->fetch_assoc();
            if (password_verify($row['salt'].$this->password,$row['password'])){
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role_num'];
                $_SESSION['UID'] = $row['id'];
                header("Location: ../main_page.php");
            }
            else{
                echo "Nooo";
            }
        }
    }
    $email = $_POST['emailInput'];
    $password = $_POST['passwordInput'];
    $user = new LoginUser($email,$password,$conn);
    $user->checkPassword();
?>