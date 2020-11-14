<?php

require_once 'common.php';

date_default_timezone_set("Asia/Singapore");

$user_id = $_SESSION['userid'];

$chat_id = $_SESSION['chat_id'];

/*
$user_id = 1;
$chat_id = 480703954;
*/

$testDateStr = strtotime("now");


$startTime = date("H:i:s", strtotime("+1 hour", $testDateStr));
$finalTime = date("H:i:s", strtotime("+2 hour", $testDateStr));
$finalDate = date("Y-m-d", strtotime("+1 hour", $testDateStr));

var_dump($startTime) ;
var_dump($finalTime) ;
var_dump($finalDate) ;

$dao = new DAO();
$event_list = $dao->get_event_by_date_time($finalDate, $startTime, $finalTime, $user_id);

var_dump($event_list);

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

var_dump($events);

// make posts into json and return json data
for ($i=0; $i < count($events); $i++) { 
    $json = $events[$i];
    

    $start_time =$json['start_time'];
    $end_time = $json['end_time'];
    $title = $json['title'];
    $description = $json['description'];

    var_dump($start_time);
    var_dump($end_time);
    var_dump($title);
    var_dump($description);

    $token = '1421065755:AAFKUQFBFs2KAr53AyrHhAlE-xMpgNSHv6s';

    $data = array(
        'text' => 
        "Here is your upcoming schedule: 
        Title: '${title}' 
        start_time: '${start_time}' 
        end_time: '${end_time}' 
        description: '${description}'",

        'chat_id' => $chat_id
    );

    file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );

}


?>
