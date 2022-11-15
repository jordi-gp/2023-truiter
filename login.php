<?php declare(strict_types=1);
    session_start();

    $errors = [];
    if(isset($_SESSION["errors"])) {
        $errors = $_SESSION["errors"];
    }

    $info = [];
    if(isset($_SESSION["info"])) {
        $info = $_SESSION["info"];
    }

    require 'views/login.view.php';