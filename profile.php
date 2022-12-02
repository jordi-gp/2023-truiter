<?php
    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        $user = $_SESSION["user"];
        $name = $user["name"];
        $username = $user["username"];
        require 'views/profile.view.php';
    }
