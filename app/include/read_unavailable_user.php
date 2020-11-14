<?php


require_once 'common.php';



//Actual 

$user_id = $_SESSION['userid'];


$dao = new HANDLERDAO();
$unavailable_list = $dao->get_unavailable_user($user_id);


$uanvs = [];
foreach( $unavailable_list as $unav_object ) {
    $uanv = [];
    $uanv["unavailable_id"] = $unav_object->getUnavailableID();
    $uanv["user_id"] = $unav_object->getUser();
    $uanv["date"] = $unav_object->getDate();
    $uanv["start_time"] = $unav_object->getStartTime();
    $uanv["end_time"] = $unav_object->getEndTime();
    $uanv["repeatable"] = $unav_object->getRepeatable();
    $uanv["title"] = $unav_object->getTitle();
    $uanv["description"] = $unav_object->getDescription();
    $uanvs[] = $uanv;
}

//$count = count($uanvs);

// make posts into json and return json data
$postJSON = json_encode($uanvs);
echo $postJSON;

// }

?>