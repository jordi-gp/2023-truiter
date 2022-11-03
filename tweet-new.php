<?php
    require_once 'autoload.php';

    use App\Photo;
use App\Tweet;
use App\Twitter;
use App\User;
use App\Video;

    session_start();

    $info = [];

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    }

    $user2 = $_SESSION["user"];

    if(isset($_SESSION["info"])) {
        $info = $_SESSION["info"];
    }
    require 'views/tweet-new.view.php';