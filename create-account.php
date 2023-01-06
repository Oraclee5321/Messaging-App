<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Account</title>
    <?php include "modules/links.php" ?>
    <script src="modules/reveal-passwords.js"></script>

</head>
<body>
<div class="container-sm w-25">
        <form action="php-functions/create-account-logic.php" method="POST">
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Username</label>
                <input type="text" class="form-control" name="usernameInput" id="usernameInput" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="emailInput" id="emailInput" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <input type="password" class="form-control" name="passwordInput" id="passwordInput" aria-describedby="passwordHelp">
            </div>
            <div class="mb-3">
                <label for="passwordInputConfirm" class="form-label">Re-Enter Password</label>
                <input type="password" class="form-control" name="passwordInputConfirm" id="passwordInputConfirm" id="passwordInputConfirm" aria-describedby="passwordHelp">
                <div id="passwordHelp" class="form-text">Confirm Your Password</div>
                <input type="checkbox"> <label class="form-label">Show Password</label>
            </div>
            <div class="mb-3">
                <input class="btn btn-success" type="submit" value="Create">
                <a href="index.php" class="btn btn-success">Back</a>
            </div>
        </form>
    </div>
</body>
</html>