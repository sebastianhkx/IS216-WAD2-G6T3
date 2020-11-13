<?php

require_once 'common.php';

class DAO{

    public function get_event_by_date_time($date, $past_time, $time, $user_id){


        // STEP 1
        $connMgr = new ConnectionManager();
        $conn = $connMgr->getConnection();
       
      
        // STEP 2
      
        $sql = "SELECT * from event_list WHERE user_id = :user_id AND DATE = :date AND start_time between :past_time and :time";
      
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':past_time', $past_time, PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
      
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


      public function get_task_by_date_time($date, $past_time, $time, $user_id, $repeatable){


        // STEP 1
        $connMgr = new ConnectionManager();
        $conn = $connMgr->getConnection();
      
       
      
        // STEP 2
      
        $sql = "SELECT * from task_list WHERE user_id = :user_id AND DATE = :date AND start_time between :past_time and :time and repeatable = :repeatable";
      
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':past_time', $past_time, PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
        $stmt->bindParam(':$repeatable', $repeatable, PDO::PARAM_STR);
      
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
                  $row['description']
                );
        }
      
        // STEP 5
        $stmt = null;
        $conn = null;
      
        // STEP 6
        return $task_list;
      
      }


}



?>
