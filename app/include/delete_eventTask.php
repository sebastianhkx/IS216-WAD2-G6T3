<?php

require_once 'common.php';

$user_id = $_SESSION['userid'];
//$username = $_SESSION['username'];

//post id
$id = $_POST['id'];
$taskType = $_POST['taskType'];
//$user_id = $_POST['user_id'];

//var_dump($user_id);

$dao = new HANDLERDAO();

if($taskType == "event"){
    $status = $dao->delete_event($id, $user_id);
} else if ($taskType == "task") {
    $status = $dao->delete_task($id, $user_id);
} else {
    $status = $dao->delete_unavailable($id, $user_id);
}


if ($status) {
  echo json_encode(array("statusCode"=>200));
} 
else {
  echo json_encode(array("statusCode"=>201));
}


?>