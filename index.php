<?php
    use App\Registry;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;
    use App\Helpers\FlashMessage;

    require_once 'bootstrap.php';

    try {
        $db = Registry::get(Registry::DB);
        $tweetRepository = Registry::get(TweetRepository::class);
        $userRepository = Registry::get(UserRepository::class);
        $tweets = $tweetRepository->findAll();
        $users = $userRepository->findAll();

        $numOfTweets = count($tweets);
        $numOfUsers = count($users);

    } catch (PDOException $err) {
        die($err->getLine().": ".$err->getMessage());
    }

    require 'views/index.view.php';
