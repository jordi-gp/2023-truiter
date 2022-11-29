<?php
    require_once "bootstrap.php";
    use App\Helpers\FlashMessage;
    $message = "S'ha tancat la sessió";

    session_unset();
    session_destroy();

    session_start();
    FlashMessage::set('message', $message);
    header("Location: index.php");
    exit();


