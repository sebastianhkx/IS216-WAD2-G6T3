<?php


require_once 'common.php';



//Actual 

$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$user_id = $_POST['user_id'];


$dao = new HANDLERDAO();
$unavailable_list = $dao->clash_checker_unavailable_non_repeat($date, $start_time, $end_time, $user_id);


$uanvs = [];
foreach( $unavailable_list as $unav_object ) {
    $uanv = [];
    $uanv["unavailabe_id"] = $unav_object->getUnavailableID();
    $uanv["user_id"] = $unav_object->getUser();
    $uanv["date"] = $unav_object->getDate();
    $uanv["start_time"] = $unav_object->getStartTime();
    $uanv["end_time"] = $unav_object->getEndTime();
    $uanv["repeatable"] = $unav_object->getRepeatable();
    $uanv["title"] = $unav_object->getTitle();
    $uanv["description"] = $unav_object->getDescription();
    $uanvs[] = $uanv;
}

$count = count($uanvs);

// make posts into json and return json data
$postJSON = json_encode(array("counter"=>$count));
echo $postJSON;

// }

?>