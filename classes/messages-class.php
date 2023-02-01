<?php
class Message {
    public $message_id;
    public $message_content;
    public $user_id;
    public $conn;
    public $has_reply;

    function __construct( $message_content, $user_id, $conn){
        // $this->message_id = $message_id;
        $this->message_content = $message_content;
        $this->user_id = $user_id;
        $this->conn = $conn;
        // $this->has_reply = $has_reply;
    }

    function save() {
        $sanitized_message_content = mysqli_real_escape_string($this->conn, $this->message_content);
        $sanitized_message_content  = strip_tags($sanitized_message_content , '<br>');
        $sql = "INSERT INTO messages (message_content,user_id) values ('$sanitized_message_content ','$this->user_id')";
        $sqlquery = $this->conn->query($sql);
        // set messageID
    }

}