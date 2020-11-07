<?php
/* please search and add "schedule" in your telegram first */
                                                                                                                
   $date=$_POST['date'];
   $description=$_POST['description'];
   $end_time=$_POST['end_time'];
   $start_time=$_POST['start_time'];
   $title=$_POST['title'];
   $user_id=$_POST['user_id'];
   $repeatable=$_POST['repeatable'];
   
   date_default_timezone_set("Singapore");
   $localdate = date("Y-m-d");
   $localtime = date("H:i:s");

   $msg = 'Thanks for using our app! This is your schedule information: User_id:'.$user_id.' Title:'.$title.' Date:'.$date.' Start_time:'.$start_time.' End_time:'.$end_time.' Discription:'.$discription.' Repeatable:'.$repeatable ;
   
  
   $botToken="1453127689:AAGeTdOsjUXuLfq9dIFioTUSy1HBJTQ4Sks";
   $chatId=817589572;
   $params=[
       'chat_id'=>$chatId, 
       'text'=>$msg,
   ];
   $website='https://api.telegram.org/bot'.$botToken.'/sendMessage?'. http_build_query($params);


   f $local = $localdate+" "+$localtime;
   $input = $date+" "+$start_time;
   list($year,$month,$day,$hour,$minute)=split ("[-: ]",$local);
   list($year1,$month1,$day1,$hour1,$minute1)=split ("[-: ]",$input);
   $seconds=mktime($hour,$minute,$month,$day,$year);
   $seconds1=mktime($hour1,$minute1,$month1,$day1,$year1);
   $sleep = $seconds1-$seconds;
   sleep($sleep);ile_get_contents($website);
   
   file_get_contents($website);
   

 /* $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);*/
?>
