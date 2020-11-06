<?php



require_once 'common.php';



//Actual 


$month = $_POST['month'];
$year = $_POST['year'];
$user_id = $_POST['user_id'];

//Test



$dao = new HANDLERDAO();
$event_list = $dao->get_event_by_month($month, $year, $user_id);

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
// make posts into json and return json data
$postJSON = json_encode($events);
echo $postJSON;



?>