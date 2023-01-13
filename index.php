<?php
    include "php-functions/db-connection.php";
    $conn = connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Login</title>
    <?php include "modules/links.php" ?>
    <script src="modules/reveal-passwords.js"></script>

</head>
<body>
    <div class="container-sm w-25">
        <form action="php-functions/sign-in.php" method="POST">
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="emailInput" id="emailInput" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <input type="password" class="form-control" name="passwordInput" id="passwordInput" aria-describedby="passwordHelp">
                <input type="checkbox"> <label class="form-label"> Show Password</label>
            </div>
            <div class="mb-3">
                <input class="btn btn-success" type="submit" value="Sign In">
                <a href="create-account.php" class="btn btn-success">Create An Account</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close()
?>