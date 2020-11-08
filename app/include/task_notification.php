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
            $task_id= $row['task_id'];
            $start_time =  $row['start_time'];
            $end_time =  $row['end_time'];    
            $title=  $row['title'];
            $description=  $row['description'];
            $repeatable =  $row['repeatable'];
            
    }
    
    $msg = 'Thanks for using our app! This is your schedule information: User_id:'.$user_id.' Title:'.$title.' Date:'.$date.' Start_time:'.$start_time.' End_time:'.$end_time.' Description:'.$description.' Repeatable:'.$repeatable;
    
    $botToken="1453127689:AAGeTdOsjUXuLfq9dIFioTUSy1HBJTQ4Sks";
    $chatId=817589572;
    $params=[
           'chat_id'=>$chatId, 
           'text'=>$msg,
           
    ];
    $website='https://api.telegram.org/bot'.$botToken.'/sendMessage?'. http_build_query($params);
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
    date_default_timezone_set("Singapore");
    
    $localdate = strtotime(date("Y-m-d"));
    $localtime = strtotime(date("H:i:s"));
    $date1 = strtotime($date);
    $start_time1 = strtotime($start_time);
    $end_time1 = strtotime($end_time);
    
    if (($localdate >= $date1)&&($localtime >= $start_time1)&&($localtime <= $end_time1)){
        echo "<script language=JavaScript> location.replace(location.href);</script>";
       }
    */
?>
