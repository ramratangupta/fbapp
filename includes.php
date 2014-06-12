<?php

require './vendor/autoload.php';

session_start();
//Auto logout after some FB session expire
if (isset($_SESSION['User']['expiresIn'], $_SESSION['User']['sessioen_create_at'])) {
    $time_diff = time() - $_SESSION['User']['sessioen_create_at'];
    if ($time_diff > $_SESSION['User']['expiresIn']) {
        //FB session is now expired
        header("Location : index.php");
    }
}