<?php
    session_start();

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        $name = $_SESSION["user"]["name"];
        $username = $_SESSION["user"]["username"];
        require 'views/profile.view.php';
    }
