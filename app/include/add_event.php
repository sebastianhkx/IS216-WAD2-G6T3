<?php

require_once 'common.php';

$date=$_POST['date'];
$description=$_POST['description'];
$end_time=$_POST['end_time'];
$start_time=$_POST['start_time'];
$title=$_POST['title'];
// To edit when proper
$user_id=$_POST['user_id'];
////
$location=$_POST['location'];
$completed = 0;

$dao = new HANDLERDAO();
$status = $dao->add_event($user_id,$date,$start_time,$end_time,$location,$title,$description,$completed);


if ($status) {
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}


?>