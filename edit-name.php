<?php
    session_start();

    if(isset($_SESSION["logged"])) {
        //Connexió a la bbdd
        require_once 'dbConnection.php';

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
