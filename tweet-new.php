<?php
    require_once 'autoload.php';
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
        $errors = [];
        if(isset($_SESSION["errors"])) {
            $errors = $_SESSION["errors"];
        }
        //Informació de l'usuari que ens interesa guardar
        if(isset($_SESSION["info"])) {
            $info = $_SESSION["info"];
        }

        if(!empty($_SESSION["newTweet"])) {
            $tweet = $_SESSION["newTweet"];
            $tweetAuthor = $tweet->getAuthor();
        }
    }

    require 'views/tweet-new.view.php';