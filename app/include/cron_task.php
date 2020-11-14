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
$Day = date("D", strtotime("+1 hour", $testDateStr));

var_dump($startTime) ;
var_dump($finalTime) ;
var_dump($finalDate) ;

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
            "Here is your upcoming schedule: 
            Title: '${title}' 
            start_time: '${start_time}' 
            end_time: '${end_time}' 
            description: '${description}'",

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
            "Here is your upcoming schedule: 
            Title: '${title}' 
            start_time: '${start_time}' 
            end_time: '${end_time}' 
            description: '${description}'",

            'chat_id' => $chat_id
        );

        file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );

    }
}

    
$repeatable = "Non-Repeat";

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
        "Here is your upcoming schedule: 
        Title: '${title}' 
        start_time: '${start_time}' 
        end_time: '${end_time}' 
        description: '${description}'",

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
            "Here is your upcoming schedule: 
            Title: '${title}' 
            start_time: '${start_time}' 
            end_time: '${end_time}' 
            description: '${description}'",
    
            'chat_id' => $chat_id
        );
    
        file_get_contents("https://api.telegram.org/bot${token}/sendMessage?" . http_build_query($data) );
    
    }
        
}





?>
