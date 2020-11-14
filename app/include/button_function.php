<?php

require_once 'common.php';

date_default_timezone_set("Asia/Singapore");


$user_id = $_SESSION['userid'];

$chat_id = $_SESSION['chat_id'];

/*

$user_id = 1;
$chat_id = 480703954;

*/


$startTime = "00:00:00";
$finalTime = "23:59:59";
$finalDate = date("Y-m-d");


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
    $location = $json['location'];

    var_dump($start_time);
    var_dump($end_time);
    var_dump($title);
    var_dump($description);

    $token = '1421065755:AAFKUQFBFs2KAr53AyrHhAlE-xMpgNSHv6s';

    $data = array(
        'text' => 
        "Here is your upcoming event schedule one hour later: 
        Title: '${title}' 
        Start time: '${start_time}' 
        End Time: '${end_time}'
        Location: '${location}' 
        Description: '${description}'",

        'chat_id' => $chat_id
    );

    file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );

}

$Day = date("D");

var_dump($Day);

if ($Day == "Mon" || $Day == "Tue" || $Day == "Wed" || $Day == "Thu" || $Day == "Fri") {

    $repeatable = "Weekday";

    $dao = new DAO();

    $task_list = $dao->get_task_by_date_time($finalDate, $startTime, $finalTime, $user_id, $repeatable);

    var_dump($task_list);

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

    var_dump($tasks);

    // make posts into json and return json data
    for ($i=0; $i < count($tasks); $i++) { 
        $json = $tasks[$i];
        

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
            "You have a task coming up later!: 
            Title: '${title}' 
            Start Time: '${start_time}' 
            End Time: '${end_time}' 
            Description: '${description}'",
    
            'chat_id' => $chat_id
        );

        file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );

    }

} elseif ($Day == "Sat" || $Day == "Sun") {

    $repeatable = "Weekend";

    $dao = new DAO();

    $task_list = $dao->get_task_by_date_time($finalDate, $startTime, $finalTime, $user_id, $repeatable);

    var_dump($task_list);

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

    var_dump($tasks);

    // make posts into json and return json data
    for ($i=0; $i < count($tasks); $i++) { 
        $json = $tasks[$i];
        

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
            "You have a task coming up later!: 
            Title: '${title}' 
            Start Time: '${start_time}' 
            End Time: '${end_time}' 
            Description: '${description}'",
    
            'chat_id' => $chat_id
        );

        file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );

    }
}

    
$repeatable = "Non Repeat";

$dao = new DAO();

$task_list = $dao->get_task_by_date_time($finalDate, $startTime, $finalTime, $user_id, $repeatable);

var_dump($task_list);

$tasks_2 = [];
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
    $tasks_2[] = $task;
}

var_dump($tasks_2);

// make posts into json and return json data
for ($i=0; $i < count($tasks_2); $i++) { 
    $json = $tasks_2[$i];
    

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
        "You have a task coming up later!: 
        Title: '${title}' 
        Start Time: '${start_time}' 
        End Time: '${end_time}' 
        Description: '${description}'",

        'chat_id' => $chat_id
    );

    file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );

}


$repeatable = "Repeat Weekly";

$dao = new DAO();

$task_list = $dao->get_task_by_time($startTime, $finalTime, $user_id, $repeatable);

var_dump($task_list);

$tasks_3 = [];
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
    $tasks_3[] = $task;
}

for ($i=0; $i < count($tasks_3) ; $i++) { 
    
    //// Check through each repeat weekly task

    $json = $tasks_3[$i];
    

    $cur_date =$json['date'];
    var_dump($cur_date);
    $day_string = date("D", strtotime($cur_date));
    var_dump($day_string);
    var_dump($Day);
    var_dump($day_string == $Day);


    if ($day_string == $Day) {

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
            "You have a task coming up later!: 
            Title: '${title}' 
            Start Time: '${start_time}' 
            End Time: '${end_time}' 
            Description: '${description}'",
    
            'chat_id' => $chat_id
        );
    
        file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );
    
    }

}


?>