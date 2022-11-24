<?php
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        # Informació de l'usuari
        $user_info = $_SESSION["user"];

        # Errors del formulari
        $errors = FlashMessage::get('update_username_errors');

        require 'views/edit-username.view.php';
    }