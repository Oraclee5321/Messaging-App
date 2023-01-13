<?php
session_start();
include "php-functions/db-connection.php";
include "classes/user-class.php";
$conn = connect();
$user = new User($_SESSION['UID'], $_SESSION['username'], $_SESSION['email'], $_SESSION['role'], connect());
if ($user->role_num < 1){
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
<div class="modal fade modal-lg" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAccountModal">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="admin-menu.php" method="POST">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="editUsernameLabel">Username</span>
                                    <input type="text" class="form-control" maxlength="50" minlength="1" id="editUsernameInput" name="editUsernameInput">
                                    <span class="input-group-text" id="editUsernameCharCounter"> / 50</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="editEmailLabel">Email</span>
                                    <input type="text" class="form-control" maxlength="50" minlength="1" id="editEmailInput" name="editEmailInput">
                                    <span class="input-group-text" id="editEmailCharCounter"> / 50</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="editRoleLabel">Role</span>
                                    <select class="form-select" id="editRoleInput" name="editRoleInput">
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Send" name="sendMessageButton" data-bs-dismiss="modal">
                </div>
            </form>
        </div>
    </div>
</div>

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
               <input type="button" class="btn btn-primary" value="Edit User" onclick="editUser('.$tempuser->id.') " data-bs-toggle="modal" data-bs-target="#editAccountModal">
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
