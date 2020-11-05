<?php


require_once 'common.php';



//Actual 

//$month = $_POST['month'];
//$year = $_POST['year'];


//Test
$repeatable = $_POST['repeatable'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$user_id = $_POST['user_id'];


$dao = new HANDLERDAO();
$event_list = $dao->clash_checker_task($repeatable, $start_time, $end_time, $user_id);


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

$count = count($tasks);

// make posts into json and return json data
$postJSON = json_encode(array("counter"=>$count));
echo $postJSON;

// }

?>