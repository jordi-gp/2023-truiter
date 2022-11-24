<?php
    require_once 'src/App/Helpers/FlashMessage.php';
    $message = "S'ha tancat la sessió";

    if(!isset($_SESSION)) {
        session_start();
        if(isset($_SESSION["logged"])) {
            session_unset();
            session_destroy();
        }
        session_start();
        FlashMessage::set('message', $message);
        header("Location: index.php");
        exit();
    }

