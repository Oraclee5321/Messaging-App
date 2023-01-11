<?php
include "db-connection.php";
$conn = connect();
$id = $_POST['messageIDValue'];
$text = mysqli_real_escape_string($conn,['editMessageInput']);
echo $id;
$sql = "UPDATE messages SET message_content = '".$text."' WHERE message_id =".$id."";
$sqlquery = $conn->query($sql);
$conn->close();
header("Location: ../main_page.php");
?>