<?php
    /* please search and add "schedule" in your telegram first */

    $Json_Object = $_POST["Json_Object"];
    $chat_id = $_POST["chat_id"]

    $json = json_decode($Json_Object, $chat_id);


        $start_time =$json->start_time;
        $end_time = $json->end_time;
        $title = $json->title;
        $description = $json->description;

        $token = "1421065755:AAFKUQFBFs2KAr53AyrHhAlE-xMpgNSHv6s";

        $data = [
            'text' => "Here is your upcoming schedule: 
            Title: ${title} 
            start_time: ${start_time} 
            end_time: ${end_time} 
            description: ${description}",

            'chat_id' => "${chat_id}"
        ];

        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );

?>