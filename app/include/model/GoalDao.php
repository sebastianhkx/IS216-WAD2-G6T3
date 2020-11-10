<?php

require_once 'common.php';

class GoalDao {


  //Get goal of the day!! -> Can return empty goal, that means not set!

  public function get_goal_of_day($user_id, $date){


    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();

    // STEP 2

    $sql = "SELECT * from goal_table 
            WHERE user_id = :user_id AND date = :date";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);

    // STEP 3
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // STEP 4
    $goalList = [];
    while( $row = $stmt->fetch() ) {
      $goalList[] =
          new Goal(
              $row['goal_id'],
              $row['user_id'],
              $row['date'],
              $row['description']
            );
    }

    // STEP 5
    $stmt = null;
    $conn = null;
  
    // STEP 6
    return $goalList;

  }


  //Get goal of the day!! -> Can return empty goal, that means not set!

  public function insert_goal_day($user_id, $date, $description){


    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();

    // STEP 2

    $sql = "INSERT INTO goal_table
    (
        user_id, 
        date, 
        description
    )
VALUES
    (
        :user_id,
        :date,
        :description
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    // STEP 3
    $status = $stmt->execute();

    // STEP 4
    $stmt = null;
    $conn = null;
    
    // STEP 5
    return $status;

  }

  public function edit_goal_data($goal_id, $user_id ,$date, $description){


    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();
  
    // STEP 2
  
    $sql = "Update goal_table 
    SET date = :date, description= :description
    WHERE user_id = :user_id AND goal_id = :goal_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':goal_id', $goal_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
  
      //STEP 3
      $status = $stmt->execute();
  
      // STEP 4
      $stmt = null;
      $conn = null;
  
      // STEP 5
      return $status;
  
  }

  public function delete_goal($goal_id, $user_id) {
    // STEP 1
    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();
  
    // STEP 2
    $sql = "DELETE FROM
                goal_table
            WHERE 
                goal_id = :goal_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':goal_id', $goal_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  
    //STEP 3
    $status = $stmt->execute();
    
    // STEP 4
    $stmt = null;
    $conn = null;
  
    // STEP 5
    return $status;
  }

}