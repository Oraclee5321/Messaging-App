<?php
class Message {
    public $message_id;
    public $message_content;
    public $user_id;
    public $conn;
    public $has_reply;
    public $username;
    public $pfp_image_link;

    function __construct($message_content, $user_id, $conn){
        // $this->message_id = $message_id;
        $this->message_content = $message_content;
        $this->user_id = $user_id;
        $this->conn = $conn;
        // $this->has_reply = $has_reply;
    }

    static function getById($message_id, $conn){
        $sql = "SELECT * FROM messages WHERE message_id = $message_id";
        $sqlquery = $conn->query($sql);
        $row = $sqlquery->fetch_assoc();
        $m = new Message($row['message_content'], $row['user_id'], $conn);
        $m->message_id = $row['message_id'];
        $m->has_reply = $row['has_reply'];
        return $m;
    }

    static function getAll($conn){
        $sql = "SELECT message_id,message_content,user_id,has_reply,users.username,users.pfp_image_link FROM messages LEFT JOIN users ON messages.user_id = users.id ORDER BY message_id DESC;";
        $sqlquery = $conn->query($sql);
        $messages = array();
        while ($row = $sqlquery->fetch_assoc()){
            $m = new Message($row['message_content'], $row['user_id'], $conn);
            $m->message_id = $row['message_id'];
            $m->has_reply = $row['has_reply'];
            $m->username = $row['username'];
            $m->pfp_image_link = $row['pfp_image_link'];
            array_push($messages, $m);
        }
        return $messages;
    }

    function save() {
        $sanitized_message_content = mysqli_real_escape_string($this->conn, $this->message_content);
        $sanitized_message_content  = strip_tags($sanitized_message_content , '<br>');
        $sql = "INSERT INTO messages (message_content,user_id) values ('$sanitized_message_content ','$this->user_id')";
        $sqlquery = $this->conn->query($sql);
        $last_id = $this->conn->insert_id;
        // set messageID
        $this->message_id = $last_id;
    }

    function update(){
        $text = strip_tags($this->message_content, '<br>');
        $sql = "UPDATE messages SET message_content = '".$text."' WHERE message_id =".$this->message_id."";
        $sqlquery = $this->conn->query($sql);
    }

    function delete(){
        $sql = "DELETE FROM messages WHERE message_id =".$this->message_id."";
        $sqlquery = $this->conn->query($sql);
    }

    function setReply($original_message_id){
        $sql = "UPDATE messages SET has_reply = 1 WHERE message_id =".$original_message_id."";
        $sqlquery = $this->conn->query($sql);
        $sql = "INSERT INTO replies (message_id, new_message_id) values ('$original_message_id','$this->message_id')";
        $sqlquery = $this->conn->query($sql);
    }

}