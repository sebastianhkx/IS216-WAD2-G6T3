<?php

//if ( !isset($_SESSION['userid'])) {
//    header("Location: login.html"); 
//    exit();
//}

require_once 'common.php';



//Actual 

//$month = $_POST['month'];
//$year = $_POST['year'];


//Test
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$user_id = $_POST['user_id'];


$dao = new HANDLERDAO();
$event_list = $dao->clash_checker($date, $start_time, $end_time, $user_id);


$events = [];
foreach( $event_list as $event_object ) {
    $event = [];
    $event["event_id"] = $event_object->getEventID();
    $event["user_id"] = $event_object->getUser();
    $event["date"] = $event_object->getDate();
    $event["start_time"] = $event_object->getStartTime();
    $event["end_time"] = $event_object->getEndTime();
    $event["location"] = $event_object->getLocation();
    $event["title"] = $event_object->getTitle();
    $event["description"] = $event_object->getDescription();
    $event["completed"] = $event_object->getCompleted();
    $events[] = $event;
}

$count = count($events);

// make posts into json and return json data
$postJSON = json_encode(array("counter"=>$count));
echo $postJSON;

// }

?>