<?php
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        # Informació de l'usuari
        $userInfo = $_SESSION["user"];

        # Errors del formulari
        $errors = FlashMessage::get('update_name_error');

        require 'views/edit-name.view.php';
    }
