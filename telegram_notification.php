<?php
  $botToken="1453127689:AAGeTdOsjUXuLfq9dIFioTUSy1HBJTQ4Sks";
  $submit = $_POST[submit];
  $task_id = $_GET[task_id];
  $date = $_GET[date];
  $discription = $_GET[discription];
  $start_time = $_GET[start_time];
  $end_time = $_GET[end_time];
  $repeatable = $_GET[repeatable];
  $title = $_GET[title];
  $user_id = $_GET[user_id];
  $chatId=817589572;
  if(isset($submit)){
    $msg = 'Thanks for using our app! This is your schedule information: task id:'.$task_id.' user_id:'.$user_id.' title:'.$title.' date:'.$date.' start_time:'.$start_time.' end_time:'.$end_time.' discription:'.$discription.' repeatable:'.$repeatable;
  }  
  
  $params=[
      'chat_id'=>$chatId, 
      'text'=>$msg,
  ];
  $website='https://api.telegram.org/bot'.$botToken.'/sendMessage?'. http_build_query($params);
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
