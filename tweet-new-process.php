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
    $img = [];
    $imgDir = "uploads";
    $validFormat = [
        "image/png" => "png",
        "image/jpg" => "jpg",
        "image/jpeg" => "jpeg"
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

        if(!empty($_FILES["tuitFile"]) && $_FILES["tuitFile"]["error"] === UPLOAD_ERR_OK) {
            //Directori on es guarden les imatges
            if(!is_dir($imgDir)) {
                mkdir($imgDir, 0777, true);
            }

            $img = $_FILES["tuitFile"];
            if(!array_key_exists($img["type"], $validFormat)) {
                $errors[] = "El format de l'imatge no es correcte";
            } else if($img["size"] > 1000000) {
                $errors[] = "El tamany de l'imatge no pot ser superior a 1MB";
            } else {
                $randName = md5($img["name"]);
                $tmpName = $img["tmp_name"];
                $imgInf = explode("/", $img["type"]);
                $imgFormat = $imgInf[1];
                move_uploaded_file($tmpName, "$imgDir/$randName.$imgFormat");
            }
        }

        //Gestió a l'hora d'enviar el formulari
        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["infoTweet"] = $tweet;
            unset($_SESSION["newTweet"]);
        } else {
            //Tuit
            $author = $_SESSION["user"];
            $newTweet = new Tweet($tweet["tuitValue"], $author);
            $_SESSION["newTweet"] = $newTweet;
            //Imatge del tuit
            $_SESSION["imgName"] = $randName.".".$imgFormat;
            unset($_SESSION["errors"]);
        }
        header("Location: tweet-new.php");
        exit();
    } else {
        header("Location: tweet-new.php");
    }