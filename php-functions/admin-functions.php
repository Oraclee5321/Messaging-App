<?php
include "db-connection.php";
include "../classes/user-class.php";

$conn = connect();
if (isset($_POST['deleteUser'])){
    $user = new User($_POST['id'],$_POST['username'],$_POST['email'],$_POST['role'],$conn);
    $user->deleteUserAdmin($conn);
}
?>