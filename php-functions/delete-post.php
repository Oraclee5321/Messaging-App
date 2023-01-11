<?php
    include "db-connection.php";
    $conn = connect();
    $id = $_POST['messageID'];
    $sql = "DELETE FROM messages WHERE message_id =".$id."";
    $sqlquery = $conn->query($sql);
    $conn->close();
    header("Location: ../main_page.php");

?>