<?php
    use App\Registry;

    require_once 'bootstrap.php';

    try {
        $db = Registry::get(Registry::DB);
        $tweetRepository = Registry::get("TweetRepository");
        $tweets = $tweetRepository->findAll();

        var_dump($tweets);
    } catch (PDOException $err) {
        die($err->getLine().": ".$err->getMessage());
    }

    # require 'views/index.view.php';
