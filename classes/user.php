<?php
class User{
    public $id;
    public $username;
    public $email;
    public $role_num;
    function __construct($id_input,$username_input,$email_input,$role_num_input){
        $this->id = $id_input;
        $this->username = $username_input;
        $this->email = $email_input;
        $this->role_num = $role_num_input;

    }
}

?>