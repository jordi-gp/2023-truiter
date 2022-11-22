<?php
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    $logged = FlashMessage::get('logged');
    if(!$logged) {
        header("Location: index.php");
        exit();
    } else {
        # Informació de l'usuari
        $userInfo = FlashMessage::get('user');

        # Errors del formulari
        $errors = FlashMessage::get('update_name_error');

        require 'views/edit-name.view.php';
    }
