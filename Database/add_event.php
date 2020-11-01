<?php

include 'connectionv2.php';

$date=$_POST['date'];
$description=$_POST['description'];
$end_time=$_POST['end_time'];
$start_time=$_POST['start_time'];
$title=$_POST['title'];
$event_id=$_POST['event_id'];
$user_id=$_POST['user_id'];
$location=$_POST['location'];
$completed = 0;

$sql = "INSERT INTO `event_list`( `event_id`, `user_id`, `date`, `start_time` , `end_time`, `location`, `title`, `description`, `completed`) 
VALUES ('$event_id','$user_id','$date','$start_time','$end_time','$location','$title','$description','$completed')";
if (mysqli_query($conn, $sql)) {
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}

mysqli_close($conn);


?>