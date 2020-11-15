<?php

require_once 'common.php';

class HANDLERDAO {


  //Event Handling//////////////////////////////////////////////////////////////

  public function get_event_user($user_id){


    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();

    // STEP 2

    $sql = "SELECT * from event_list where user_id = :user_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

    // STEP 3
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // STEP 4
    $event_list = [];
    while( $row = $stmt->fetch() ) {
      $event_list[] =
          new EVENT(
              $row['event_id'],
              $row['user_id'],
              $row['date'],
              $row['start_time'],
              $row['end_time'],
              $row['location'],
              $row['title'],
              $row['description'],
              $row['completed']
            );
    }

    // STEP 5
    $stmt = null;
    $conn = null;
  
    // STEP 6
    return $event_list;

  }


  public function add_event($user_id, $date, $start_time, $end_time, $location, $title, $description, $completed ) {

    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();

    $sql = "INSERT INTO event_list
    (
        user_id, 
        date, 
        start_time, 
        end_time,
        location,
        title,
        description,
        completed
    )
VALUES
    (
        :user_id,
        :date,
        :start_time,
        :end_time,
        :location,
        :title,
        :description,
        :completed
    )";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);
$stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
$stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
$stmt->bindParam(':location', $location, PDO::PARAM_STR);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':completed', $completed, PDO::PARAM_STR);

//STEP 3
$status = $stmt->execute();

// STEP 4
$stmt = null;
$conn = null;

// STEP 5
return $status;
}


public function delete_event($id, $user_id) {
  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2
  $sql = "DELETE FROM
              event_list
          WHERE 
              event_id = :id AND user_id = :user_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

  //STEP 3
  $status = $stmt->execute();
  
  // STEP 4
  $stmt = null;
  $conn = null;

  // STEP 5
  return $status;
}


public function clash_checker($date, $start_time, $end_time, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();
  

  // STEP 2

  $sql = "SELECT * from event_list 
          WHERE user_id = :user_id AND 
          DATE between :date and :date AND 
          (start_time between :start_time and :end_time OR end_time between :start_time and :end_time)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
  $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
  $stmt->bindParam(':date', $date, PDO::PARAM_STR);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $event_list = [];
  while( $row = $stmt->fetch() ) {
    $event_list[] =
        new EVENT(
            $row['event_id'],
            $row['user_id'],
            $row['date'],
            $row['start_time'],
            $row['end_time'],
            $row['location'],
            $row['title'],
            $row['description'],
            $row['completed']
          );
  }

  // STEP 5
  $stmt = null;
  $conn = null;

  // STEP 6
  return $event_list;

}


public function edit_event_data($user_id, $event_id ,$date, $start_time, $end_time, $location, $title, $description){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  $properties_input = "SET date = :date, start_time= :start_time, end_time = :end_time, location = :location, title = :title, description= :description";
  

    $check_statement = "where user_id = :user_id AND event_id = :event_id";




  // STEP 2

  $sql = "Update event_list ${properties_input} ${check_statement}";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindParam(':date', $date, PDO::PARAM_STR);
  $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
  $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
  $stmt->bindParam(':location', $location, PDO::PARAM_STR);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    //STEP 3
    $status = $stmt->execute();

    // STEP 4
    $stmt = null;
    $conn = null;

    // STEP 5
    return $status;

}


// Task Handling //////////////////////////////////////////////////////////

public function get_task_user($user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from task_list where user_id = :user_id";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $task_list = [];
  while( $row = $stmt->fetch() ) {
    $task_list[] =
        new TASK(
            $row['task_id'],
            $row['user_id'],
            $row['date'],
            $row['start_time'],
            $row['end_time'],
            $row['repeatable'],
            $row['title'],
            $row['description'],
          );
  }

  // STEP 5
  $stmt = null;
  $conn = null;

  // STEP 6
  return $task_list;

}


public function add_task($user_id, $date, $start_time, $end_time, $repeatable, $title, $description) {

  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  $sql = "INSERT INTO task_list
  (
      user_id, 
      date, 
      start_time, 
      end_time,
      repeatable,
      title,
      description
  )
  VALUES
  (
      :user_id,
      :date,
      :start_time,
      :end_time,
      :repeatable,
      :title,
      :description
  )";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindParam(':date', $date, PDO::PARAM_STR);
  $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
  $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
  $stmt->bindParam(':repeatable', $repeatable, PDO::PARAM_STR);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':description', $description, PDO::PARAM_STR);

  //STEP 3
  $status = $stmt->execute();

  // STEP 4
  $stmt = null;
  $conn = null;

  // STEP 5
  return $status;
  }


  public function delete_task($id, $user_id) {
  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2
  $sql = "DELETE FROM
              task_list
          WHERE 
              task_id = :id AND user_id = :user_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

  //STEP 3
  $status = $stmt->execute();

  // STEP 4
  $stmt = null;
  $conn = null;

  // STEP 5
  return $status;
  }


  

public function edit_task_data($user_id, $task_id ,$date, $start_time, $end_time, $repeatable, $title, $description){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();



    $properties_input = "SET date = :date, start_time= :start_time, end_time = :end_time, repeatable = :repeatable, title = :title, description= :description";
    

    $check_statement = "where user_id = :user_id AND task_id = :task_id";




    // STEP 2

    $sql = "Update task_list ${properties_input} ${check_statement}";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
    $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
    $stmt->bindParam(':repeatable', $repeatable, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);


    //STEP 3
    $status = $stmt->execute();

    // STEP 4
    $stmt = null;
    $conn = null;

    // STEP 5
    return $status;

}

//This function is specifically for work management.
//Could've been used to check for clashes...

public function get_task_by_date_time($date, $user_id, $currentTime, $weekType, $day){
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from task_list 
          where (DATE between :date and :date AND user_id = :user_id
          AND start_time < :currentTime AND end_time > :currentTime AND 
          (repeatable = :weekType OR repeatable = 'Non Repeat')) OR
          (user_id = :user_id AND start_time < :currentTime AND end_time > :currentTime AND repeatable = 'Repeat Weekly')";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindParam(':date', $date, PDO::PARAM_STR);
  $stmt->bindParam(':currentTime', $currentTime, PDO::PARAM_STR);
  $stmt->bindParam(':weekType', $weekType, PDO::PARAM_STR);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $dayArray = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  $task_list = [];
  while( $row = $stmt->fetch() ) {

    //Check if it's a repeat weekly task!!
    if($row['repeatable'] == "Repeat Weekly"){
      //Check if day match, if match it's a return!
      $unixTimestamp = strtotime($row['date']);
      $dayOfWeekStr = date("l", $unixTimestamp);
      $dayOfWeekNum = array_search($dayOfWeekStr, $dayArray);
      
      if ($dayOfWeekNum == $day){
        $task_list[] =
        new TASK(
            $row['task_id'],
            $row['user_id'],
            $row['date'],
            $row['start_time'],
            $row['end_time'],
            $row['repeatable'],
            $row['title'],
            $row['description'],
          );
      }
    } else {
    $task_list[] =
        new TASK(
            $row['task_id'],
            $row['user_id'],
            $row['date'],
            $row['start_time'],
            $row['end_time'],
            $row['repeatable'],
            $row['title'],
            $row['description'],
          );
        }
  }

  // STEP 5
  $stmt = null;
  $conn = null;

  // STEP 6
  return $task_list;

}


////////////// Unavailable list /////////////////////////////////////////////////////
public function get_unavailable_user($user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from unavailable_list where user_id = :user_id";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $unavailable_list = [];
  while( $row = $stmt->fetch() ) {
    $unavailable_list[] =
        new UNAVAILABLE(
            $row['unavailable_id'],
            $row['user_id'],
            $row['date'],
            $row['start_time'],
            $row['end_time'],
            $row['repeatable'],
            $row['title'],
            $row['description'],
          );
  }

  // STEP 5
  $stmt = null;
  $conn = null;

  // STEP 6
  return $unavailable_list;

}



public function add_unavailable($user_id, $date, $start_time, $end_time, $repeatable, $title, $description) {

  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  $sql = "INSERT INTO unavailable_list
  (
      user_id, 
      date, 
      start_time, 
      end_time,
      repeatable,
      title,
      description
  )
VALUES
  (
      :user_id,
      :date,
      :start_time,
      :end_time,
      :repeatable,
      :title,
      :description
  )";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);
$stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
$stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
$stmt->bindParam(':repeatable', $repeatable, PDO::PARAM_STR);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);

//STEP 3
$status = $stmt->execute();

// STEP 4
$stmt = null;
$conn = null;

// STEP 5
return $status;
}


public function delete_unavailable($id, $user_id) {
// STEP 1
$connMgr = new ConnectionManager();
$conn = $connMgr->getConnection();

// STEP 2
$sql = "DELETE FROM
            unavailable_list
        WHERE 
            unavailable_id = :id AND user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

//STEP 3
$status = $stmt->execute();

// STEP 4
$stmt = null;
$conn = null;

// STEP 5
return $status;
}



public function edit_unava_data($user_id, $unavailable_id ,$date, $start_time, $end_time, $repeatable, $title, $description){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  $properties_input = "SET date = :date, start_time= :start_time, end_time = :end_time, repeatable = :repeatable, title = :title, description= :description";
    

  $check_statement = "where user_id = :user_id AND unavailable_id = :unavailable_id";




  // STEP 2

    $sql = "UPDATE unavailable_list ${properties_input} ${check_statement}";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':unavailable_id', $unavailable_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
    $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
    $stmt->bindParam(':repeatable', $repeatable, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);


    //STEP 3
    $status = $stmt->execute();

    // STEP 4
    $stmt = null;
    $conn = null;

    // STEP 5
    return $status;

}





}
