<?php
    include "db-connection.php";
    $conn = connect();
    function generateSalt(){
        $salt = "";
        $saltLength = 22;
        for ($i = 0; $i < $saltLength; $i++){
            $salt .= chr(mt_rand(33,126));
        }
        return $salt;
    }
    function encryptPassword($password,$salt){
        $password = $salt.$password;
        return password_hash($password, PASSWORD_DEFAULT);
    }
    function checkPasswords($password, $passwordConfirm){
        if ($password == $passwordConfirm){
            return true;
        }
        else{
            return false;
        }
    }
    class User
    {
        public $username;
        public $email;
        public $password;
        public $salt;
        private $conn;

        function __construct($username, $email, $password, $conn, $salt)
        {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->conn = $conn;
            $this->salt = $salt;
        }

        function insert()
        {
            $sql = "INSERT INTO users (username, email, password,is_active,salt) VALUES ('$this->username', '$this->email', '$this->password', '0', '$this->salt')";
            $sqlquery = $this->conn->query($sql);
        }
    }
    $salt = generateSalt();
    $username = $_POST['usernameInput'];
    $email = $_POST['emailInput'];
    $password = encryptPassword($_POST['passwordInput'],$salt);
    $passwordConfirm = $_POST['passwordInputConfirm'];
    $user = new User($username, $email, $password, $conn, $salt);
    $user->insert();
    $conn->close();
    header("Location: ../index.php");
?>