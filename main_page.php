<?php
session_start();
include "php-functions/db-connection.php"
?>
<html>
<head>
    <?php include "modules/links.php" ?>
</head>
<body>
    <?php include "modules/navbar.php" ?>
    <br>
    <div class="d-flex justify-content-center">
        <?php
            $conn = connect();
            $sql = "SELECT * FROM messages";
            $sqlquery = $conn->query($sql);
            while($row = $sqlquery->fetch_assoc()) {
                $namesql = "SELECT username FROM users WHERE id = '$row[user_id]'";
                $namesqlquery = $conn->query($namesql);
                $username = $namesqlquery->fetch_assoc();
                echo '<div class="card" style="width: 18rem;">
                        <div class="card-title">
                           User: '.$username['username'].'
                        </div>
                        <div class="card-body">
                           '.$row['message_content'].'
                        </div>
                      </div>';
            }
        ?>
    </div>
    <input type="text" id="send_message" placeholder="Enter a message">
    <button id="send_button">Send</button>
</body>
</html>
