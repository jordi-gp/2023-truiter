<?php
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        $user = $_SESSION["user"];
        $name = $user["name"];
        $username = $user["username"];
        require 'views/profile.view.php';
    }
