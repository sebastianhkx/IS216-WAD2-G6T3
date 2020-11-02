<?php

require_once 'common.php';

class HANDLERDAO {


  //Event Handling//////////////////////////////////////////////////////////////

  public function get_event(){


    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();

    // STEP 2

    $sql = "SELECT * from event_list";

    $stmt = $conn->prepare($sql);

    // STEP 3
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // STEP 4
    $task_list = [];
    while( $row = $stmt->fetch() ) {
      $task_list[] =
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
    return $task_list;

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


public function delete_event($id) {
  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2
  $sql = "DELETE FROM
              event_list
          WHERE 
              id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  //STEP 3
  $status = $stmt->execute();
  
  // STEP 4
  $stmt = null;
  $conn = null;

  // STEP 5
  return $status;
}


// Task Handling //////////////////////////////////////////////////////////

public function get_task(){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from task_list";

  $stmt = $conn->prepare($sql);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $task_list = [];
  while( $row = $stmt->fetch() ) {
    $task_list[] =
        new EVENT(
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


public function delete_task($id) {
// STEP 1
$connMgr = new ConnectionManager();
$conn = $connMgr->getConnection();

// STEP 2
$sql = "DELETE FROM
            task_list
        WHERE 
            id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

//STEP 3
$status = $stmt->execute();

// STEP 4
$stmt = null;
$conn = null;

// STEP 5
return $status;
}

}

?>