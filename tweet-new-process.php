<?php declare(strict_types=1);

    use App\Helpers\UploadedFileHandler;
    require_once 'autoload.php';
    require_once 'dbConnection.php';
    require_once 'src/App/Helpers/FlashMessage.php';
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
    $validFormat[] = "image/jpg";
    $validFormat[] = "image/jpeg";
    $validFormat[] = "image/png";
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

        $handle_image = new UploadedFileHandler($_FILES["tuitFile"], $validFormat,300000);
        var_dump($handle_image->handle($imgDir));


        //Gestió a l'hora d'enviar el formulari
        if(!empty($errors)) {
            FlashMessage::set('new_tweet_errors', $errors);
            FlashMessage::set('infoTweet', $tweet);
            unset($_SESSION["newTweet"]);
            header("Location: tweet-new.php");
            exit();
        } else {
            //Informació de l'usuari
            $user_info = $_SESSION["user"];
            $created_at = new DateTime();

            $stmt = $pdo->prepare("INSERT INTO tweet(text, created_at, like_count, user_id) VALUES(:text, :created_at, :like_count, :user_id)");
            $stmt->bindValue(':text', $tweet["tuitValue"]);
            $stmt->bindValue(':created_at', $created_at->format("Y-m-d h:i:s"));
            $stmt->bindValue(':like_count', 0);
            $stmt->bindValue(':user_id', $user_info["id"]);
            #$stmt->execute();

            //Imatge del tuit
            if($_FILES["tuitFile"]["error"] === UPLOAD_ERR_OK) {
                $tuitId = $pdo->lastInsertId();

                //Tamany de l'imatge
                $size = getimagesize($handle_image->handle($imgDir));
                var_dump($size);
                $width = $size[0];
                $height = $size[0];
                if($imageValid) {
                    $stmt = $pdo->prepare("INSERT INTO media (alt_text, height, width, url, tuit_id) VALUES (:alt_text, :height, :width, :url, :tuit_id)");
                    $stmt->bindValue(':alt_text', "imatge_tuit");
                    $stmt->bindValue(':height', $height);
                    $stmt->bindValue(':width', $width);
                    $stmt->bindValue(':url', $rutaImg);
                    $stmt->bindValue(':tuit_id', $tuitId);
                    #$stmt->execute();
                }
            }
            unset($_SESSION["errors"]);
            # header("Location: index.php");
        }
        # exit();
    } else {
        header("Location: tweet-new.php");
        exit();
    }