<?php
    use App\Core\View;

    use App\Registry;

    use App\Helpers\FlashMessage;

    use App\Services\UserRepository;
    use App\Services\TweetRepository;

    require_once 'bootstrap.php';

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
    $confirm_message = FlashMessage::get('confirm_message');

    echo View::render('index', 'default', compact('tweets', 'users', 'numOfTweets', 'numOfUsers'));
