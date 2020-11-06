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
$event_id=$_POST['event_id'];


$dao = new HANDLERDAO();
$status = $dao->edit_event_data($user_id,$event_id,$date,$start_time,$end_time,$location,$title,$description);


if ($status) {
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}


?>

