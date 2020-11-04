<?php

//if ( !isset($_SESSION['userid'])) {
//    header("Location: login.html"); 
//    exit();
//}

require_once 'common.php';

$date=$_POST['date'];
$description=$_POST['description'];
$end_time=$_POST['end_time'];
$start_time=$_POST['start_time'];
$title=$_POST['title'];
// To edit when proper
$user_id=$_POST['user_id'];
////
$repeatable=$_POST['repeatable'];

$dao = new HANDLERDAO();
$status = $dao->add_unavailable($user_id,$date,$start_time,$end_time,$repeatable,$title,$description);

if ($status) {
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}


// }

?>