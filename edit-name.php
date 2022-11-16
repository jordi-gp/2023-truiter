<?php
    session_start();

    if(isset($_SESSION["logged"])) {
        //Informació de l'usuari
        $userInfo = $_SESSION["user"];

        if(isset($_SESSION["errors"])) {
            $errors = $_SESSION["errors"];
        }

        require 'views/edit-name.view.php';
    } else {
        header("Location: index.php");
        exit();
    }
