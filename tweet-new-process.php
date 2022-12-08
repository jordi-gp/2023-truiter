<?php declare(strict_types=1);
    const MAX_SIZE = 1024 * 1024 * 3;

    require_once 'bootstrap.php';

    use App\User;
    use App\Tweet;
    use App\Photo;
    use App\Registry;

    use App\Services\PhotoRepository;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;

    use App\Helpers\Validator;
    use App\Helpers\FlashMessage;
    use App\Helpers\UploadedFileHandler;

    use App\Helpers\Exceptions\UploadedFileException;
    use App\Helpers\Exceptions\NoUploadedFileException;

    $errors = [];
    $tweet = [
        "tuitValue" => "",
        "tuitFile" => []
    ];
    $imgDir = "uploads";
    $validFormat[] = "image/jpg";
    $validFormat[] = "image/jpeg";
    $validFormat[] = "image/png";

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $userRepository = Registry::get(UserRepository::class);
        $tweetRepository = Registry::get(TweetRepository::class);
        $photoRepository = Registry::get(PhotoRepository::class);
        $validator = Registry::get(Validator::class);


        # Validació del tuit
        if(empty($_POST["tuitValue"])) {
            $errors[] = "No es pot publicar un tuit buit";
        } else {
            try {
                $validator->lengthBetween($_POST["tuitValue"], 2, 250);
                $tweet["tuitValue"] = filter_var($_POST["tuitValue"], FILTER_SANITIZE_SPECIAL_CHARS);
            } catch (InvalidArgumentException $err) {
                $errors[] = $err->getMessage();
            }
        }

        if(!empty($_FILES)) {
            try {
                $handle_image = new UploadedFileHandler($_FILES["tuitFile"], $validFormat, MAX_SIZE);
                var_dump($handle_image->handle($imgDir));
            } catch (NoUploadedFileException $e) {
            } catch (UploadedFileException $e){
                $errors[] = $e->getMessage();
            } catch (Exception $exception) {
                $errors[] = $exception->getMessage();
            }

        }

        # Gestió a l'hora d'enviar el formulari
        if(!empty($errors)) {
            FlashMessage::set('new_tweet_errors', $errors);
            FlashMessage::set('infoTweet', $tweet);
            unset($_SESSION["newTweet"]);
            header("Location: tweet-new.php");
            exit();
        } else {
            # Afegiment d'un nou tweet
            $user_info = $_SESSION["user"];
            $tweetAuthor = new User($user_info["name"], $user_info["username"]);
            $newTweet = new Tweet($tweet["tuitValue"], $tweetAuthor);

            $tweetRepository->save($newTweet);

            # Imatge del tuit
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
                    $stmt->execute();
                }
            }
            unset($_SESSION["errors"]);
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: tweet-new.php");
        exit();
    }