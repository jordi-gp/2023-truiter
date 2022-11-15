<?php
    session_start();

    //Errors del formulari
    $register_error = [];
    if(isset($_SESSION["register_error"])) {
        $register_error = $_SESSION["register_error"];
    }

    //Informació correcta del formulari
    $form = [];
    if(isset($_SESSION["form"])) {
        $form = $_SESSION["form"];
    }
    require_once 'views/register.view.php';
