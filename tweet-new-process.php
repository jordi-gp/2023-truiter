<?php declare(strict_types=1);
    use App\Photo;
use App\Tweet;
use App\Twitter;
use App\User;
use App\Video;
    require_once 'autoload.php';
    session_start();

    $isPost = false;
    $errors = [];
    $author = [];
    $tweet = [
        "tuitValue" => "",
        "tuitFile" => []
    ];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
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
            unset($_SESSION["newTweet"]);
        } else {
            $author = $_SESSION["user"];
            $newTweet = new Tweet($tweet["tuitValue"], $author);
            $_SESSION["newTweet"] = $newTweet;
            unset($_SESSION["errors"]);
        }
        header("Location: tweet-new.php");
        exit();
    } else {
        header("Location: tweet-new.php");
    }