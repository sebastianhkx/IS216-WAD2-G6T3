<?php



require_once 'common.php';



//Actual 
$user_id = $_POST['user_id'];
$day = $_POST['day'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];



$dao = new HANDLERDAO();
$days_list = $dao->get_unavailable_unavailable_days($user_id, $day, $start_time, $end_time);

$unavailable_days = [];
foreach( $days_list as $day_object ) {
    $day = [];
    $day["linked_id"] = $day_object->getLinkedID();
    $day["user_id"] = $day_object->getUser();
    $day["day"] = $day_object->getDay();
    $day["start_time"] = $day_object->getStartTime();
    $day["end_time"] = $day_object->getEndTime();
    $day["unavailable_id"] = $day_object->getUnavID();

    $unavailable_days[] = $day;
}


$count = count($unavailable_days);

// make posts into json and return json data
$postJSON = json_encode(array("counter"=>$count));
echo $postJSON;



?>