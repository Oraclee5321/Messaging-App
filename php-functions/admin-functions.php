<?php
session_start();

include "db-connection.php";
include "../classes/user-class.php";
$user = new User($_SESSION['UID'],$_SESSION['username'],$_SESSION['email'],$_SESSION['role'],connect());

$conn = connect();
if (isset($_POST['deleteUser'])) {
    if ($user->role_num == 1 && $_POST['role_num'] == 1){
        $_SESSION['error'] = "You cannot delete an Admin";
    }
    elseif ($user->role_num == 2 && $_POST ['role_num'] == 2){
        $_SESSION['error'] = "You cannot delete a Super Admin";
    }else {
        $tempuser = new User($_POST['id'], $_POST['username'], $_POST['email'], $_POST['role'], $conn);
        $tempuser->deleteUserAdmin($conn);
    };
    header("Location: ../admin-menu.php");
};
if (isset($_POST['editUser'])){

    $username = $_POST['editUsernameInput'];
    $email = $_POST['editEmailInput'];
    $role = $_POST['editRoleInput'];
    $id = $_POST['id'];
    if ($user->role_num < 2 && $role == 2){
        $_SESSION['error'] = "You do not have permission to change a user's role to Super Admin.";
    } elseif ($user->role_num == 1 && $role == 1){
        $_SESSION['error'] = "You do not have permission to change a user's role to Admin.";
    } elseif ($user->role_num == 2 && User::getRole($conn,$id) == 2){
        $_SESSION['error'] = "You cannot edit a Super Admin's account.";
    }
    else {
        $sql = "UPDATE users SET username = '$username', email = '$email', role_num = '$role' WHERE id = '$id'";
        $sqlquery = $conn->query($sql);
    };
    header("Location: ../admin-menu.php");
};

?>