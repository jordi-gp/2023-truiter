<?php
    require_once 'bootstrap.php';

    use App\Core\View;

    use App\Helpers\FlashMessage;

    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Response;

    # Si no està loggejat l'usuari no pot accedir
    if(!isset($_SESSION["logged"])) {
        $redirectResponse = new RedirectResponse('/');
        $redirectResponse->send();
    } else {
        $title = "Afig un Tweet";

        # Errors del formulari
        $errors = FlashMessage::get('new_tweet_errors');

        # Informació de l'usuari
        $info = $_SESSION["user"];

        $content = View::render('tweet-new', 'default', compact('errors', 'info', 'title'));
        $response = new Response($content);
        $response->setStatusCode(Response::HTTP_OK);
        $response->send();
    }
