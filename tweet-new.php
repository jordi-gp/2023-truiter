<?php
    require_once 'bootstrap.php';

    use App\Helpers\FlashMessage;

    //Si no està loggejat l'usuari no pot accedir
    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        # Errors del formulari
        $errors = FlashMessage::get('new_tweet_errors');

        # Informació de l'usuari
        $info = $_SESSION["user"];

        require 'views/tweet-new.view.php';
    }
