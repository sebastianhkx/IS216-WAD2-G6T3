<?php

include 'connectionv2.php';

$date=$_POST['date'];
$description=$_POST['description'];
$end_time=$_POST['end_time'];
$start_time=$_POST['start_time'];
$title=$_POST['title'];
$task_id=$_POST['task_id'];
$user_id=$_POST['user_id'];
$repeatable=$_POST['repeatable'];

$sql = "INSERT INTO `task_list`( `task_id`, `user_id`, `date`, `start_time` , `end_time`, `repeatable`, `title`, `description`) 
VALUES ('$task_id','$user_id','$date','$start_time','$end_time','$repeatable','$title','$description')";
if (mysqli_query($conn, $sql)) {
  
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}

mysqli_close($conn);


?>