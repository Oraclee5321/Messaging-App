<?php
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
            }
            if (isset($_POST['editMessageInput'])){
                $id = $_POST['messageIDValue'];
                $text = mysqli_real_escape_string($conn,$_POST['editMessageInput']);
                $user->editMessage($id,$text,$conn);
            }
            if (isset($_POST['deletePostCheck'])){;
                $id = $_POST['messageID'];
                $user->deletePost($id,$conn);
            }
        }
        ?>
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
        <div class="container ">
            <div class="row">
                <div class="col">
                    <h1>Account Settings</h1>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editEmailModal">
                        <h3 class="text-start">Edit</h3>
                    </button>
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
                    var username = <?php echo $user->username ?>;
                    document.getElementById("editUsernameInput").value = username;
                    $('#editUsernameCharCounter').text(<?php echo strlen($user->username) ?> + " / 50");
                });
                document.getElementById("editUsernameButton").click();
            }
        </script>
    </body>
</html>


