<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    $info = [];

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    }

    if(isset($_SESSION["info"])) {
        $info = $_SESSION["info"];
    }

    require 'views/tweet-new.view.php';