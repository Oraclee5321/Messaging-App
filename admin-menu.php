<?php
session_start();
include "php-functions/db-connection.php";
include "classes/user-class.php";
$conn = connect();
$user = new User($_SESSION['UID'], $_SESSION['username'], $_SESSION['email'], $_SESSION['role'], connect());
 ?>
<html>
<head>
    <title>Admin Menu</title>
    <?php include "modules/links.php"; ?>
</head>
<body>

<?php include "modules/navbar.php";
if ($user->role_num < 1){
    $_SESSION['Error'] = "You do not have permission to access this page.";
    header("Location: main_page.php");
}
if (isset($_SESSION['error'])){
    ?><div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error'];?>
    </div><?php
    unset($_SESSION['error']);
}
?>
<h1>Admin Menu</h1>
<h2>Users</h2>
<div class="modal fade modal-lg" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAccountModal">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="php-functions/admin-functions.php" method="POST">
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="editUsernameLabel">Username</span>
                                    <input type="text" class="form-control" maxlength="50" minlength="1" id="editAdminUsernameInput" name="editAdminUsernameInput">
                                    <span class="input-group-text" id="editAdminUsernameCharCounter"> / 50</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="editEmailLabel">Email</span>
                                    <input type="text" class="form-control" maxlength="50" minlength="1" id="editAdminEmailInput" name="editAdminEmailInput">
                                    <span class="input-group-text" id="editAdminEmailCharCounter"> / 50</span>
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
                                        <option value="2" <?php if ($user->role_num != 2){echo "disabled";} ?>>Super Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Edit" name="editUser" data-bs-dismiss="modal">
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
    if ($tempuser->role_num == 2) {
        $issuperadmin = true;
    } else {
        $issuperadmin = false;
    }
    if ($user->role_num == 1 && $tempuser->role_num == 2) {
       continue;
    }
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
               <input type="hidden" id="id_'.$tempuser->id.'" name="id" value="' . $tempuser->id . '">
               <input type="hidden" id="username_'.$tempuser->id.'" name="username" value="' . $tempuser->username . '">
               <input type="hidden" id="email_'.$tempuser->id.'" name="email" value="' . $tempuser->email . '">
               <input type="hidden" id="role_'.$tempuser->id.'" name="role_num" value="' . $tempuser->role_num. '">
               <input type="button" class="btn btn-primary" value="Edit User" onclick="editUser('.$tempuser->id.') ">
               <button class="btn btn-danger" style="'.($issuperadmin ? "":"none").' type="submit" name="deleteUser" value="deleteUser">Delete User</button>
               <input type="button" style="display:none" data-bs-toggle="modal" data-bs-target="#editAccountModal" id="editAccountModalButton">
            </form>
           </form>
         </div>
       </div>
     </div>
       
    ';}
?>
</div>
<script src="modules/char-counter.js"></script>
<script>
    function editUser(id){
        var modal = document.getElementById("editAccountModal");
        console.log(modal);
        modal.addEventListener('show.bs.modal',function(event){
            var previousName = document.getElementById("username_" + id).value;
            console.log(previousName);
            var previousEmail = document.getElementById("email_" + id).value;
            var previousRole = document.getElementById("role_" + id).value;
            document.getElementById("editAdminUsernameInput").value = previousName;
            $('#editAdminUsernameCharCounter').text(previousName.length + " / 50");
            document.getElementById("editAdminEmailInput").value = previousEmail;
            $('#editAdminEmailCharCounter').text(previousEmail.length + " / 50");
            console.log(previousRole);
            document.getElementById("editRoleInput").value = previousRole;
            document.getElementById("id").value = id;
        });
        document.getElementById("editAccountModalButton").click();
    }
</script>
</body>
</html>
