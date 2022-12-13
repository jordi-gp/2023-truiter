<?php
    require_once 'bootstrap.php';

    use App\Core\View;

    use App\Registry;

    use App\Helpers\FlashMessage;

    use App\Services\UserRepository;
    use App\Services\TweetRepository;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    # Obtenció de valors passats per $_POST
    # $request->request('valor', 'valor per defecte');

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

    $title = "Truiter una grollera cópia de Twitter";
    # Missatges a mostrar a l'usuari
    $info = FlashMessage::get('info');
    $logout_message = FlashMessage::get('message');
    $confirm_message = FlashMessage::get('confirm_message');
    $search_errors = FlashMessage::get('search_errors');

    $content = View::render('index', 'default', compact('tweets', 'users', 'numOfTweets', 'numOfUsers', 'info', 'logout_message', 'confirm_message', 'search_errors', 'title'));
    $response = new Response($content);
    $response->setStatusCode(Response::HTTP_OK);
    $response->send();
