<?php

spl_autoload_register(function ($class){
    require_once "model/$class" . ".php";
});

    require_once './sql/ConnectionManager.php';
    session_start();
?>

?>
