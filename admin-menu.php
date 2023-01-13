<?php
include "php-functions/db-connection.php";
include "classes/user-class.php";
$conn = connect();
$user = new User($_SESSION['UID'],$_SESSION['username'],$_SESSION['email'],$_SESSION['role'],connect());
if ($user->role_num < 1){
    header("Location: main_page.php");
}
echo $user->role_num;
echo "ayyy";
?>