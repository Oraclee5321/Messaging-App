<?php
    include "db-connection.php";
    include "../classes/user-class.php";
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
    $salt = generateSalt();
    $username = $_POST['usernameInput'];
    $email = $_POST['emailInput'];
    $password = encryptPassword($_POST['passwordInput'],$salt);
    $passwordBare = $_POST['passwordInput'];
    $passwordConfirm = $_POST['passwordInputConfirm'];
    $conn = connect();
    if (checkPasswords($passwordBare,$passwordConfirm)){
        $user = new User(0,$username,$email,0,$conn);
        $user->insert($password,$salt);
        header("Location: ../index.php");
    }
    else{
        echo "Passwords do not match";
    }
?>