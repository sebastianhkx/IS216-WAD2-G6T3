<?php

require_once 'common.php';

$day=$_POST['day'];
$end_time=$_POST['end_time'];
$start_time=$_POST['start_time'];
// To edit when proper
$user_id=$_POST['user_id'];
$task_id=$_POST['task_id'];
////

$dao = new HANDLERDAO();
$status = $dao->add_unavailable_task_days($user_id, $day, $start_time, $end_time, $task_id);

if ($status) {
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}


?>