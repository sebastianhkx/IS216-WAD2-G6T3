<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'common.php';
session_start();

if( trim($_POST['username']) != '' && trim($_POST['password']) != '' ) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Authenticate
    $dao = new UserDAO();

    // Call AccountDAO's getHashedPassword($username) to hashed_password stored in Account table
    // See what getHashedPassword($username) returns.
    //    NULL if username is NOT found in Account table
    //    hashed_password (String) if username is found in Account table

    $result = $dao->getUserDetails($username);

    //if username does not exist
    if ($result == null){
        $msg = "Username doesn't exist!";
        echo $msg;
        return;
    }

    $AuthPass = $result->getHashedPassword();
    $id = $result->getUserId();

    $status = password_verify($password,$AuthPass);

    if($status === FALSE){

        $msg = "Your username/password could be wrong!";
        echo $msg;
        
        return;

    } else {
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $id;
        $msg = "Login success!";
        echo $msg;
        return;
    }
}
else {
    // Oh oh... both username/password fields must be filled out!

    // 1) Register Error message as a Session Variable
    $msg = "Some reason, one input is empty...";
    echo $msg;
    return;

}

?>