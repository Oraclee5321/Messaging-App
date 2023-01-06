<?php

function connect(){
    $servername ="localhost";
    $username = "petsdatabase";
    $password = "123";

    $conn = new mysqli($servername,$username,$password,"message_app");
    if ($conn->connect_error){
        die("Connection Failed ".$conn->connect_error);
    }
    return $conn;

}

?>