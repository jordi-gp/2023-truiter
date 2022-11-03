<?php
// ací va la lògica per a processar el formulari de creació de tuits
    if(!isset($_SESSION)){
        session_start();
    }

    $isPost = false;
    $errors = [];
    $tweet = [
        "tuitValue" => "",
        "tuitFile" => []
    ];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $isPost = true;
    }

    if($isPost) {
        //Validació del formulari
        if(!empty($_POST["tuitValue"])) {
            if(strlen($_POST["tuitValue"]) > 250) {
                $errors[] = "Un tweet no pot contindre més de 100 caracters";
            } else {
                $tweet["tuitValue"] = filter_var($_POST["tuitValue"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $errors[] = "No es pot publicar un tweet en blanc!";
        }

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["infoTweet"] = $tweet;
            header("tweet-new.php");
            exit();
        } else {

        }
    } else {
        header("Location: tweet-new.php");
    }