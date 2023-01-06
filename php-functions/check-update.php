<?php
    include "db-connection.php";
    $conn = connect();
    $sql = "SELECT message_id FROM messages ORDER BY message_id DESC LIMIT 1";
    $sqlquery = $conn->query($sql);
    $result = $sqlquery->fetch_assoc();
    echo json_encode($result['message_id']);

?>