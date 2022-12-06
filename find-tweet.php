<?php
    require_once 'bootstrap.php';
    use App\Helpers\FlashMessage;
    use App\Helpers\Validator;
    use App\Registry;
    use App\Services\TweetRepository;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        # Requeriment dels serveis necessàris
        try {
            $db = Registry::get(Registry::DB);
            $validator = Registry::get(Validator::class);
            $tweetRepository = Registry::get(TweetRepository::class);
        } catch (Exception $err) {
            die($err->getLine()." ".$err->getMessage());
        }

        $value_search = "";
        $search_errors = [];

        if(!empty($_POST["tuit_search"])) {
            $validator->lengthBetween($_POST["tuit_search"], 0, 280);
            if(strlen($_POST["tuit_search"]) > 280) {
                $search_errors[] = "Un tuit no pot contindre més de 280 caracters";
            } else {
                $value_search = filter_var($_POST["tuit_search"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $search_errors[] = "No es pot realitzar una búsqueda sense indicar un valor";
        }

        if(empty($search_errors)) {
            $found_tweets = $tweetRepository->findTweetBy($value_search);

            unset($_SESSION["search_errors"]);

            require_once "views/found-tweet.view.php";
        } else {
            FlashMessage::set('search_errors', $search_errors);
            header("Location: index.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }