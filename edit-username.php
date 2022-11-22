<?php
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    $logged = FlashMessage::get('logged');
    if(!$logged) {
        header("Location: index.php");
        exit();
    } else {
        # Informació de l'usuari
        $user_info = FlashMessage::get('user');

        $errors = FlashMessage::get('update_username_errors');

        require 'views/edit-username.view.php';
    }