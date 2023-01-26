<?php
session_start();
include "php-functions/db-connection.php";
include "classes/user-class.php";
$conn = connect();
$user = new User($_SESSION['UID'],$_SESSION['username'],$_SESSION['email'],$_SESSION['role'],connect());
?>
<html>
    <head>
        <?php include "modules/links.php" ?>
    </head>
    <body>
        <?php include "modules/navbar.php" ?>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['editUsernameInput'])){
                $newUsername = $_POST['editUsernameInput'];
                $user->changeUsername($newUsername, $conn);
                header("Location: account-settings.php");
            }
            if (isset($_POST['editEmailInput'])){
                $newUsername = $_POST['editEmailInput'];
                $user->changeEmail($newUsername, $conn);
                header("Location: account-settings.php");
            }
            if (isset($_POST['deletePostCheck'])){;
                $id = $_POST['messageID'];
                $user->deletePost($id,$conn);
                header("Location: account-settings.php");
            }
        }
        ?>
        <!-- Edit Username Modal -->
        <div class="modal fade" id="editUsernameModal" tabindex="-1" aria-labelledby="editUsernameLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editUsernameLabel">Edit Username</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="account-settings.php" method="POST">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" maxlength="50" minlength="1" id="editUsernameInput" name="editUsernameInput">
                                <span class="input-group-text" id="editUsernameCharCounter"> / 50</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Edit" name="editUsernameButton" data-bs-dismiss="modal">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Edit Username Modal -->
        <!-- Edit Email Modal -->
        <div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editEmailLabel">Edit Username</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="account-settings.php" method="POST">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" maxlength="50" minlength="1" id="editEmailInput" name="editEmailInput">
                                <span class="input-group-text" id="editEmailCharCounter"> / 50</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Edit" name="editEmailButton" data-bs-dismiss="modal">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Edit Email Modal -->
        <!-- Edit PFP Modal -->
        <div class="modal fade" id="editAvatarModal" tabindex="-1" aria-labelledby="editAvatarLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editAvatarLabel">Edit Username</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="account-settings.php" method="POST">
                        <div class="modal-body">
                            <img id="editAvatarPreview" src="..." width="100px" height="100px" class="rounded mx-auto d-block" alt="Avatar Preview" style="margin:auto">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" maxlength="255" minlength="1" id="editAvatarInput" name="editAvatarInput">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Edit" name="editAvatarButton" data-bs-dismiss="modal">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- End Edit PFP Modal -->

        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1>Account Settings</h1>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-4">
                    <h2>Avatar</h2>
                </div>
                <div class="col-6 col-md-4">
                    <img src="pfp-pictures/<?php echo $user->getPfp($conn)?>" width="100px" height="100px" class="rounded mx-auto d-block">
                </div>
                <div class="col-6 col-md-4">
                    <h2><input type="button" class="btn btn-primary" value="Change" onclick="currentAvatar()" /></h2>
                    <button type="button" style="display:none" data-bs-toggle="modal" data-bs-target="#editAvatarModal") id="editAvatarButton"></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-4">
                    <h2 class="text-start">Username</h2>
                </div>
                <div class="col-6 col-md-4">
                    <h2 class="text-start"><?php echo $user->username ?></h2>
                </div>
                <div class="col-6 col-md-4">
                    <h2><input type="button" class="btn btn-primary" value="Change" onclick="currentUsername()" /></h2>
                    <button type="button" style="display:none" data-bs-toggle="modal" data-bs-target="#editUsernameModal") id="editUsernameButton"></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-4">
                    <h2 class="text-start">Email</h2>
                </div>
                <div class="col-6 col-md-4">
                    <h2 class="text-start"><?php echo $user->email ?></h2>
                </div>
                <div class="col-6 col-md-4">
                    <h2><input type="button" class="btn btn-primary" value="Change" onclick="currentEmail()" /></h2>
                    <button type="button" style="display:none" data-bs-toggle="modal" data-bs-target="#editEmailModal") id="editEmailButton"></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-4">
                    <h2 class="text-start">Role</h2>
                </div>
                <div class="col-6 col-md-4">
                    <h2 class="text-start"><?php echo $user->getRoleName() ?></h2>
                </div>
            </div>
        </div>
        <script src="modules/char-counter.js"></script>
        <script type="text/javascript">
            function currentUsername() {
                var modal = document.getElementById("editUsernameModal");
                modal.addEventListener('show.bs.modal',function(event){
                    var username = "<?php echo $user->username ?>";
                    document.getElementById("editUsernameInput").value = username;
                    $('#editUsernameCharCounter').text(<?php echo strlen($user->username) ?> + " / 50");
                });
                document.getElementById("editUsernameButton").click();
            };
            function currentEmail(){
                var modal = document.getElementById("editEmailModal");
                modal.addEventListener('show.bs.modal',function(event){
                    var email = "<?php echo $user->email ?>";
                    document.getElementById("editEmailInput").value = email;
                    $('#editEmailCharCounter').text(<?php echo strlen($user->email) ?> + " / 50");
                });
                document.getElementById("editEmailButton").click();
            }
            function currentAvatar(){
                console.log("test");
                var modal = document.getElementById("editAvatarModal");
                modal.addEventListener('show.bs.modal',function(event){
                    var pfp = "pfp-pictures/<?php echo $user->getPfp($conn)?>"
                    document.getElementById("editAvatarPreview").src = pfp;
                    $('#editEmailCharCounter').text(<?php echo strlen($user->email) ?> + " / 50");
                });
                document.getElementById("editAvatarButton").click();
            };
        </script>
    </body>
</html>


