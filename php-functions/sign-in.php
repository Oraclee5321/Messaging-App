<?php
    session_start();
    include "db-connection.php";
    include "../classes/user-class.php";
    $conn = connect();
    $email = $_POST['emailInput'];
    $password = $_POST['passwordInput'];
    $user = new User(0,"",$email,0,$conn);
    $user->checkPassword($password);
?>