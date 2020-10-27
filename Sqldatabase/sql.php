<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "schedule";
$port = 3308;

try{
    $conn = new PDO("mysql:host=$servername;dbname = $dbname ", $username, $password,$port);

    //set fault    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE schedule";
    // create table
   $sql =" CREATE TABLE IF NOT EXISTS schedule (
        date varchar(32) NOT NULL,
        time varchar(32) NOT NULL,
        location varchar(32) NOT NULL,
        description varchar(32) NOT NULL,
        /*importance varchar(32) NOT NULL,
        complete varchar(32) NOT NULL,*/
        PRIMARY KEY (date)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
          if(isset($_GET["eventDate"])) {
            $date = $_GET["evenDate"];}
        
        if(isset($_GET["eventTime"])) {
            $time = $_GET["evenTime"];}
        
        if(isset($_GET["eventLocation"])) {
            $location = $_GET["evenLocation"];}  

    // insert data
    $conn->beginTransaction();
    $conn->exec("INSERT INTO schedule(date, time,location) VALUES($date, $time,$location)");

    // no return
    //$conn->exec($sql);
    $conn->commit();
    
}
catch(PDOException $e)
{
    $conn->rollback();
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
