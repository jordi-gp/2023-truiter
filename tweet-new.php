<?php
    require_once 'autoload.php';
    require_once 'src/App/Helpers/FlashMessage.php';
    use App\Photo;
    use App\Tweet;
    use App\Twitter;
    use App\User;
    use App\Video;
    session_start();

    //Si no està loggejat l'usuari no pot accedir
    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        # Errors del formulari
        $errors = FlashMessage::get('new_tweet_errors');

        # Informació de l'usuari
        $info = $_SESSION["user"];
    }

    require 'views/tweet-new.view.php';