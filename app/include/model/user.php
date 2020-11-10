<?php 

// DO NOT MODIFY THE CODES

class User {
    private $userid;
    private $name;
    private $hashed_password;
    private $tele_handle;

    public function __construct($userid, $name, $hashed_password, $tele_handle){
        $this->userid = $userid;
        $this->name = $name;
        $this->hashed_password = $hashed_password;
        $this->tele_handle = $tele_handle;
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

    public function getTeleHandle(){
        return $this->tele_handle;
    }

}
?>