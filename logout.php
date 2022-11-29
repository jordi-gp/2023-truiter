<?php
    use App\Helpers\FlashMessage;
    $message = "S'ha tancat la sessió";

    session_start();
    if(isset($_SESSION["logged"])) {
        session_unset();
        session_destroy();
    }

    session_start();
    FlashMessage::set('message', $message);
    header("Location: index.php");
    exit();

