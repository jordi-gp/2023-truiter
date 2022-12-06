<?php declare(strict_types=1);

    use App\Registry;
    use App\Helpers\FlashMessage;
    use App\Services\UserRepository;
    use App\Services\TweetRepository;
    use App\Services\PhotoRepository;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        require_once 'bootstrap.php';

        $userInf = $_SESSION["user"];
        try {
            $tweet_repository = Registry::get(TweetRepository::class);
            $user_repository = Registry::get(UserRepository::class);
            $photo_repository = Registry::get(PhotoRepository::class);
        } catch (Exception $err) {
            die($err->getLine()." ".$err->getMessage());
        }

        # Obtenció dels tuits amb imatge de l'usuari
        $tweetMedia = $photo_repository->selectMedia($userInf["id"]);

        foreach($tweetMedia as $media) {
            $photo_repository->deleteMedia($media["tuit_id"]);
        }

        # Eliminació dels tuits de l'usuari
        $tweet_repository->deleteTweetsFromUser($userInf["id"]);

        # Eliminació de l'usuari de la bbdd
        $user_repository->deleteUserById($userInf["id"]);

        # Missatge flash de confirmació per a l'usuari
        $flash_message = "L'usuari s'ha eliminat de forma correcta!";
        FlashMessage::set('confirm_message', $flash_message);

        unset($_SESSION["user"]);
        unset($_SESSION["logged"]);

        header("Location: index.php");
        exit();
    } else {
        header('Location: index.php');
        exit();
    }
