<?php
    require_once "bootstrap.php";
    use App\Helpers\FlashMessage;

    session_unset();
    session_destroy();

    session_start();
    $message = "S'ha tancat la sessió correctament";
    FlashMessage::set('message', $message);
    header("Location: index.php");
    exit();


