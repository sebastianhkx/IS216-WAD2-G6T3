<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'common.php';

if( trim($_POST['username']) != '' && trim($_POST['password']) && trim($_POST['username']) != '' ) {

    // All 3 form input fields are filled out!
    // Retrieve form input values
    $username = $_POST['username'];
    $password = $_POST['password'];
    $tele_handle = $_POST['tele_handle'];
    $fullname = $_POST['fullname'];

    // If passwords do not match:    
  //  if($password !== $retype_password){
   //     echo "Password mismatch";
   //     return;
  //  }


    // Passwords do match so proceed with registration!
    $dao = new UserDAO();

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    //Check for registration!
    $result = $dao->getUserDetails($username);

    //If user already registered, kick them out!
    if($result != null) {
        echo "User is already registered!";
        return;
    }

    //If it's a success, register user!
    $register_result = $dao->register($username, $hashedPass, $tele_handle, $fullname);


    // If registration in Account table was SUCCESSFUL
    if($register_result === TRUE){
        $msg = "User $username has successfully registered!";
        echo $msg;
        return;
    } else {
        // Registration failed!
        $msg = "User $username could not be registered!";
        echo $msg;
        return;
    }
    
}
else {
    // Not all 2 input fields are filled out!
    $msg = "All 3 fields must be filled out";
    echo $msg;
    return;

}

?>
