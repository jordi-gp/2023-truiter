<?php
    require_once 'bootstrap.php';

    use App\Helpers\FlashMessage;
    use App\Registry;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;

    try {
        $db = Registry::get(Registry::DB);
        $tweetRepository = Registry::get(TweetRepository::class);
        $userRepository = Registry::get(UserRepository::class);
        $tweets = $tweetRepository->findAll();
        $users = $userRepository->findAll();

        $numOfTweets = count($tweets);
        $numOfUsers = count($users);

    } catch (Exception $err) {
        die($err->getLine().": ".$err->getMessage());
    }

    # Missatges a mostrar a l'usuari
    $info = FlashMessage::get('info');
    $logout_message = FlashMessage::get('message');

    require 'views/index.view.php';
