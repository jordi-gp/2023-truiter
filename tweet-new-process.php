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
    use App\Helpers\Exceptions\InvalidArgumentException;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    $errors = [];
    $tweet = [
        "tuitValue" => "",
        "tuitFile" => []
    ];
    $imgDir = "uploads";
    $validFormat[] = "image/jpg";
    $validFormat[] = "image/jpeg";
    $validFormat[] = "image/png";

    $request = Request::createFromGlobals();

    $request_method = $request->server->get('REQUEST_METHOD');
    if($request_method === "POST") {
        $userRepository = Registry::get(UserRepository::class);
        $tweetRepository = Registry::get(TweetRepository::class);
        $photoRepository = Registry::get(PhotoRepository::class);
        $validator = Registry::get(Validator::class);

        # Validació del tuit
        $tuitValue = $request->get('tuitValue');
        try {
            $validator->lengthBetween($tuitValue, 2, 250);
            $tweet["tuitValue"] = filter_var($tuitValue, FILTER_SANITIZE_SPECIAL_CHARS);
        } catch (InvalidArgumentException $err) {
            $errors[] = $err->getMessage();
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

            $redirectResponse = new RedirectResponse('tweet-new.php');
        } else {
            # Afegiment d'un nou tweet
            $user_info = $_SESSION["user"];
            $tweetAuthor = new User($user_info["name"], $user_info["username"]);
            $tweetAuthor->setId((int) $user_info["id"]);

            $newTweet = new Tweet($tweet["tuitValue"], $tweetAuthor);
            $newTweet->setCreatedAt(new DateTime());
            $newTweet->setLikeCount(0);

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
            $redirectResponse = new RedirectResponse('index.php');
        }
        $redirectResponse->send();
    } else {
        header("Location: tweet-new.php");
        exit();
    }