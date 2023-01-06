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
            $this->username = mysqli_real_escape_string($conn,$username);
            $this->email = mysqli_real_escape_string($conn,$email);
            $this->password = mysqli_real_escape_string($conn,$password);
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
    $passwordBare = $_POST['passwordInput'];
    $passwordConfirm = $_POST['passwordInputConfirm'];
    if (checkPasswords($passwordBare,$passwordConfirm)){
        $user = new User($username,$email,$password,$conn,$salt);
        $user->insert();
        header("Location: ../index.php");
    }
    else{
        echo "Passwords do not match";
    }
?>