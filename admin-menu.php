<?php
include "php-functions/db-connection.php";
include "classes/user-class.php";
$conn = connect();
$user = new User($_SESSION['UID'], $_SESSION['username'], $_SESSION['email'], $_SESSION['role'], connect());
if ($user->role_num < 1) {
    header("Location: main_page.php");
} ?>
<html>
<head>
    <title>Admin Menu</title>
    <?php include "modules/links.php"; ?>
</head>
<body>
<?php include "modules/navbar.php"; ?>
<h1>Admin Menu</h1>
<h2>Users</h2>

<div class="accordion" id="usersAccordion">
<?php
$sql = "SELECT * FROM users";
$sqlquery = $conn->query($sql);
while ($row = $sqlquery->fetch_assoc()) {
    $tempuser = new User($row['id'], $row['username'], $row['email'], $row['role_num'], $conn);
    echo
    '
     <div class="accordion-item">
       <h2 class="accordion-header" id="'.$tempuser->id.'Header">
         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#'.$tempuser->id.'Collapse" aria-expanded="false" aria-controls="'.$tempuser->id.'Collapse">
           ' . $tempuser->username . '
         </button>
       </h2>
       <div id="'.$tempuser->id.'Collapse" class="accordion-collapse collapse" aria-labelledby="#'.$tempuser->id.'Header" data-bs-parent="#usersAccordion">
         <div class="accordion-body">
           <p>Username: ' . $tempuser->username . '</p>
           <p>Email: ' . $tempuser->email . '</p>
           <p>Role: ' . $tempuser->getRoleName() . '</p>
           <form method="POST" action="php-functions/admin-functions.php">
               <input type="hidden" name="id" value="' . $tempuser->id . '">
               <input type="hidden" name="username" value="' . $tempuser->username . '">
               <input type="hidden" name="email" value="' . $tempuser->email . '">
               <input type="hidden" name="role" value="' . $tempuser->role_num . '">
               <button class="btn btn-danger" type="submit" name="deleteUser" value="deleteUser">Delete User</button>
               <input type="button" class="btn btn-primary" value="Edit User" onclick="editUser('.$tempuser->id.')">
           </form>
         </div>
       </div>
     </div>
       
    ';}
?>
</div>
<script>
    function editUser(id){
        console.log(id);
    }
</script>
</body>
</html>
