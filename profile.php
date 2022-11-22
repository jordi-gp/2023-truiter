<?php
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    $logged = FlashMessage::get('logged');
    if(!$logged) {
        header("Location: index.php");
        exit();
    } else {
        $user = FlashMessage::get('user');
        $name = $user["name"];
        $username = $user["username"];
        require 'views/profile.view.php';
    }
