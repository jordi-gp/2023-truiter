<?php declare(strict_types=1);

    if(!isset($_SESSION)) {
        session_start();
        if(!isset($_SESSION["logged"])) {
            header("Location: index.php");
            exit();
        } else {
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit();
        }
    }

