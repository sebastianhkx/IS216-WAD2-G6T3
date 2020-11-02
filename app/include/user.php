<?php 

// DO NOT MODIFY THE CODES

class User {
    private $userid;
    private $name;
    private $hashed_password;

    public function __construct($userid, $name, $hashed_password){
        $this->userid = $userid;
        $this->name = $name;
        $this->hashed_password = $hashed_password;
    }

    public function getUserId(){
        return $this->userid;
    }

    public function getName(){
        return $this->name;
    }

    public function getHashedPassword(){
        return $this->hashed_password;
    }

}
?>