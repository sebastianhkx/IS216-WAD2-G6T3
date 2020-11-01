<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once './generate.php';
include_once './connection.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$event_getter = new Event_Get($db);

// query products
$stmt = $event_getter->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num > 0) {

    // products array
    $result_arr = array();
    $result_arr["records"] = array();

    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $item = array(
            "id" => [
                "event_id" => $event_id,
                "user_id" => $user_id
            ],
            
            "location" => $location,
    
            "Time" => [
                "start" => $start_time,
                "end" => $end_time,
                "date" => $date
            ],
    
            "info" => [
                "title" => $title,
                "desc" => $description,
            ],
            
            "completed" => $completed

        );

        array_push($result_arr["records"], $item);
    }

    // Add info node (1 per response)
    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($result_arr);
}
else {
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no items found
    echo json_encode(
        array("message" => "No records found.")
    );
}
?>