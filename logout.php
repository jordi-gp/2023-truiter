<?php declare(strict_types=1);
    $mesage = "s'ha tancat la sessió";

    if(!isset($_SESSION)) {
        session_start();
        if(isset($_SESSION["logged"])) {
            session_unset();
            session_destroy();
        }
        session_start();
        $_SESSION["message"] = $mesage;
        header("Location: index.php");
        exit();
    }

