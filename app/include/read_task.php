<?php

//if ( !isset($_SESSION['userid'])) {
//    header("Location: login.html"); 
//    exit();
//}

require_once 'common.php';


$dao = new HANDLERDAO();
$task_list = $dao->get_task();

$tasks = [];
foreach( $task_list as $task_object ) {
    $task = [];
    $task["task_id"] = $task_object->getTaskID();
    $task["user_id"] = $task_object->getUser();
    $task["date"] = $task_object->getDate();
    $task["start_time"] = $task_object->getStartTime();
    $task["end_time"] = $task_object->getEndTime();
    $task["repeatable"] = $task_object->getRepeatable();
    $task["title"] = $task_object->getTitle();
    $task["description"] = $task_object->getDescription();
    $task["completed"] = $task_object->getCompleted();
    $tasks[] = $task;
}
// make posts into json and return json data
$postJSON = json_encode($tasks);
echo $postJSON;

// }

?>