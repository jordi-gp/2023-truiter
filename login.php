<?php
    require_once 'autoload.php';

    use App\Photo;
    use App\Tweet;
    use App\Twitter;
    use App\User;
    use App\Video;

    session_start();

    $errors = [];
    if(isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    }

    $info = [];
    if(isset($_SESSION["info"])) {
        $info = $_SESSION["info"];
    }

    if(isset($_SESSION["logged"])) {
        $user2 = $_SESSION["user"];
    }

    require 'views/login.view.php';