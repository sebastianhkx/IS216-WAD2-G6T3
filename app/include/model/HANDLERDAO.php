<?php

require_once 'common.php';

class HANDLERDAO {


  //Event Handling//////////////////////////////////////////////////////////////

  public function get_event_user($user_id){


    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();

    // STEP 2

    $sql = "SELECT * from event_list where user_id = '$user_id'";

    $stmt = $conn->prepare($sql);

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


public function get_event_by_month($month, $year, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();
  

  $month_statement = "where DATE between '${year}/${month}/01' and '${year}/${month}/31' AND user_id = '${user_id}'";




  // STEP 2

$sql = "SELECT * from event_list ${month_statement}";

  $stmt = $conn->prepare($sql);

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


public function clash_checker($date, $start_time, $end_time, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();
  

  $check_statement = "where user_id = ${user_id} AND DATE between '${date}' and '${date}' AND (start_time between '${start_time}' and '${end_time}' OR end_time between '${start_time}' and '${end_time}') ";




  // STEP 2

$sql = "SELECT * from event_list ${check_statement}";

  $stmt = $conn->prepare($sql);

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

  $properties_input = "SET date = ${date}, start_time= ${start_time}, end_time = ${end_time}, location = ${location}, title = ${title}, description=${description}"
  

  $check_statement = "where user_id = ${user_id} AND event_id = ${event_id}";




  // STEP 2

  $sql = "Update event_list ${properties_input} ${check_statement}";
  $stmt = $conn->prepare($sql);


    //STEP 3
    $status = $stmt->execute();

    // STEP 4
    $stmt = null;
    $conn = null;

    // STEP 5
    return $status;

}

public function get_event_by_date($date, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();
  

  $date_statement = "where DATE between '${date}' and '${date}' ";



  // STEP 2

  $sql = "SELECT * from event_list ${date_statement}";

  $stmt = $conn->prepare($sql);

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


// Task Handling //////////////////////////////////////////////////////////

public function get_task_user($user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from task_list where user_id = ${user_id}";

  $stmt = $conn->prepare($sql);

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


public function get_task_by_month($month, $year, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  
  $month_statement = "where DATE between '${year}/${month}/01' and '${year}/${month}/31' AND user_id = '${user_id}'";


  // STEP 2

$sql = "SELECT * from task_list ${month_statment}";

  $stmt = $conn->prepare($sql);

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


public function clash_checker_task($repeatable, $start_time, $end_time, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();
  

  $check_statement = "where user_id = ${user_id} AND repeatable = '${repeatable}' AND (start_time between '${start_time}' and '${end_time}' OR end_time between '${start_time}' and '${end_time}') ";




  // STEP 2

$sql = "SELECT * from task_list ${check_statement}";

  $stmt = $conn->prepare($sql);

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

public function edit_task_data($user_id, $task_id ,$date, $start_time, $end_time, $repeatable, $title, $description){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  $properties_input = "SET date = ${date}, start_time= ${start_time}, end_time = ${end_time}, repeatable = ${repeatable}, title = ${title}, description=${description}"
  

  $check_statement = "where user_id = ${user_id} AND task_id = ${task_id}";




  // STEP 2

  $sql = "Update task_list ${properties_input} ${check_statement}";
  $stmt = $conn->prepare($sql);


    //STEP 3
    $status = $stmt->execute();

    // STEP 4
    $stmt = null;
    $conn = null;

    // STEP 5
    return $status;

}

public function get_task_by_date($date, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  
  $date_statement = "where DATE between '${date}' and '${date}'";


  // STEP 2

$sql = "SELECT * from task_list ${date_statement}";

  $stmt = $conn->prepare($sql);

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


////////////// Unavailable list /////////////////////////////////////////////////////
public function get_unavailable_user($user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from unavailable_list where user_id= '${user_id}';

  $stmt = $conn->prepare($sql);

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



public function get_unavailable(){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  // STEP 2

  $sql = "SELECT * from unavailable_list";

  $stmt = $conn->prepare($sql);

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


public function delete_unavailable($id) {
// STEP 1
$connMgr = new ConnectionManager();
$conn = $connMgr->getConnection();

// STEP 2
$sql = "DELETE FROM
            unavailable_list
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


public function get_unavailable_list_by_month($month, $year, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  
  $month_statement = "where DATE between '${year}/${month}/01' and '${year}/${month}/31' AND user_id = '${user_id}'";


  // STEP 2

$sql = "SELECT * from unavailable_list ${month_statment}";

  $stmt = $conn->prepare($sql);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $unavailable_list = [];
  while( $row = $stmt->fetch() ) {
    $unavailable_list[] =
        new UNAVAILABLE(
            $row['unavailabe_id'],
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

public function clash_checker_unavailable($repeatable, $start_time, $end_time, $user_id){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();
  

  $check_statement = "where user_id = ${user_id} AND repeatable = '${repeatable}' AND (start_time between '${start_time}' and '${end_time}' OR end_time between '${start_time}' and '${end_time}') ";




  // STEP 2

$sql = "SELECT * from unavailable_list ${check_statement}";

  $stmt = $conn->prepare($sql);

  // STEP 3
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC);

  // STEP 4
  $unavailable_list = [];
  while( $row = $stmt->fetch() ) {
    $unavailable_list[] =
        new UNAVAILABLE(
            $row['unavailabe_id'],
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

public function edit_unava_data($user_id, $unavailable_id ,$date, $start_time, $end_time, $repeatable, $title, $description){


  // STEP 1
  $connMgr = new ConnectionManager();
  $conn = $connMgr->getConnection();

  $properties_input = "SET date = ${date}, start_time= ${start_time}, end_time = ${end_time}, repeatable = ${repeatable}, title = ${title}, description=${description}"
  

  $check_statement = "where user_id = ${user_id} AND unavailable_id = ${unavailable_id}";




  // STEP 2

  $sql = "Update unavailable_list ${properties_input} ${check_statement}";
  $stmt = $conn->prepare($sql);


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