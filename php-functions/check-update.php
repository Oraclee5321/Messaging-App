<?php
    include "db-connection.php";
    $conn = connect();
    $sql = "SELECT message_id,message_content FROM messages ORDER BY message_id DESC LIMIT 1";
    $sqlquery = $conn->query($sql);
    $result = $sqlquery->fetch_assoc();
    $id = $result['message_id'];
    $text = $result['message_content'];
    $countsql = "SELECT COUNT(*) FROM messages";
    $countsqlquery = $conn->query($countsql);
    $count = $countsqlquery->fetch_assoc();
    echo json_encode($count['COUNT(*)'].$id.$text);

?>