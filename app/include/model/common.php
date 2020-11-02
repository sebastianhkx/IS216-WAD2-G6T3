<?php

    //date_default_timezone_set('Asia/Singapore');

    spl_autoload_register(
        function ($class){
            require_once  "./$class.php";
        }
    );

    require_once './sql/database.php';
    session_start();
?>
