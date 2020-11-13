
<?php
    /* please search and add "schedule" in your telegram first */
    require_once 'common.php';

    $connMgr = new ConnectionManager();
    $conn = $connMgr->getConnection();
    
    $sql = "SELECT * from event_list ";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    while ($row=$stmt->fetch()) {
            $date = $row['date'];
            $event_id = $row['event_id'];
            $user_id= $row['user_id'];
            $start_time =  $row['start_time'];
            $end_time =  $row['end_time'];
            $location=  $row['location'];
            $title=  $row['title'];
            $description=  $row['description'];
            $completed =  $row['completed'];
            
    }

   $msg = 'Thanks for using our app! This is your schedule information: User_id:'.$user_id.' Title:'.$title.' Date:'.$date.' Location:'.$location.' Start_time:'.$start_time.' End_time:'.$end_time.' Description:'.$description ;

   $botToken="1453127689:AAGeTdOsjUXuLfq9dIFioTUSy1HBJTQ4Sks";
   $chatId=817589572;
   $params=[
           'chat_id'=>$chatId, 
           'text'=>$msg,
           
   ];
   $website='https://api.telegram.org/bot'.$botToken.'/sendMessage?'. http_build_query($params);
   file_get_contents($website);

   date_default_timezone_set("Singapore");
   $localdate = strtotime(date("Y-m-d H:i:00"));
   $edate = strtotime($date." ".$start_time);
   $stime =$edate - $localdate;
   set_time_limit($localdate);
   sleep($stime);
   file_get_contents($website);

    $stmt = null;
    $conn = null;
 /* $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
  header("Refresh:0");
   */
?>

