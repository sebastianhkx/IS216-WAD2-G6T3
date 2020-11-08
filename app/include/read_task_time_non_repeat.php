<?php


require_once 'common.php';

//Test
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$user_id = $_POST['user_id'];


$dao = new HANDLERDAO();
$task_list = $dao->clash_checker_task_non_repeat($date, $start_time, $end_time, $user_id);


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
    $tasks[] = $task;
}

$count = count($tasks);

// make posts into json and return json data
$postJSON = json_encode(array("counter"=>$count));
echo $postJSON;

// }

?>