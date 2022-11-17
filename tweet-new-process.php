<?php declare(strict_types=1);
    use App\Photo;
use App\Tweet;
use App\Twitter;
use App\User;
use App\Video;
    require_once 'autoload.php';
    require_once 'dbConnection.php';
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
    $imageValid = false;

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
                $rutaImg = "$imgDir/$randName.$imgFormat";
                move_uploaded_file($tmpName, $rutaImg);
                $imageValid = true;
            }
        }

        //Gestió a l'hora d'enviar el formulari
        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["infoTweet"] = $tweet;
            header("Location: tweet-new.php");
            exit();
            unset($_SESSION["newTweet"]);
        } else {
            //Informació de l'usuari
            var_dump($_SESSION);
            $user_info = $_SESSION["user"];
            $created_at = new DateTime();

            $stmt = $pdo->prepare("INSERT INTO tweet(text, created_at, like_count, user_id) VALUES(:text, :created_at, :like_count, :user_id)");
            $stmt->bindValue(':text', $tweet["tuitValue"]);
            $stmt->bindValue(':created_at', $created_at->format("Y-m-d h:i:s"));
            $stmt->bindValue(':like_count', 0);
            $stmt->bindValue(':user_id', $user_info["id"]);
            $stmt->execute();

            //Imatge del tuit
            var_dump($_FILES);
            if($_FILES["tuitFile"]["error"] === UPLOAD_ERR_OK) {
                $tuitId = $pdo->lastInsertId();

                //Tamany de l'imatge
                $size = getimagesize($rutaImg);
                $width = $size[0];
                $height = $size[0];
                if($imageValid) {
                    $stmt = $pdo->prepare("INSERT INTO media (alt_text, height, width, url, tuit_id) VALUES (:alt_text, :height, :width, :url, :tuit_id)");
                    $stmt->bindValue(':alt_text', "imatge_tuit");
                    $stmt->bindValue(':height', $height);
                    $stmt->bindValue(':width', $width);
                    $stmt->bindValue(':url', $rutaImg);
                    $stmt->bindValue(':tuit_id', $tuitId);
                    $stmt->execute();
                }
            }
            unset($_SESSION["errors"]);
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: tweet-new.php");
    }