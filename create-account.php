<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Account</title>
    <?php
    session_start();
    include "modules/links.php"
    ?>
    <script src="modules/reveal-passwords.js"></script>

</head>
<body>
<div class="container-sm w-25">
        <form action="php-functions/create-account-logic.php" method="POST">
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Username</label>
                <?php if (isset($_SESSION['username'])){?>
                    <input type="text" class="form-control" name="usernameInput" id="usernameInput" value="<?php echo $_SESSION['username']?>">
                <?php } else {?>
                    <input type="text" class="form-control" name="usernameInput" id="usernameInput">
                <?php }?>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email Address</label>
                <?php if (isset($_SESSION['email'])){?>
                    <input type="email" class="form-control" name="emailInput" id="emailInput" value="<?php echo $_SESSION['email']?>">
                <?php } else {?>
                    <input type="email" class="form-control" name="emailInput" id="emailInput">
                <?php }?>
            </div>
            <div class="mb-3" id="passwordInputDiv">
                <label for="passwordInput" class="form-label">Password</label>
                <input type="password" class="form-control" name="passwordInput" id="passwordInput" aria-describedby="passwordHelp">
            </div>
            <div class="mb-3" id="passwordInputDiv">
                <label for="passwordInputConfirm" class="form-label">Re-Enter Password</label>
                <input type="password" class="form-control" name="passwordInputConfirm" id="passwordInputConfirm" id="passwordInputConfirm" aria-describedby="passwordHelp">
                <div id="passwordHelp" class="form-text">Confirm Your Password</div>
                <input type="checkbox"> <label class="form-label">Show Password</label>
                <?php
                if (isset($_SESSION['error'])){
                    ?><div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error'];?>
                    </div>
                    <?php unset($_SESSION['error']);}
                session_destroy();
                ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-success" type="submit" value="Create">
                <a href="index.php" class="btn btn-success">Back</a>
            </div>
        </form>
    </div>
</body>
</html>