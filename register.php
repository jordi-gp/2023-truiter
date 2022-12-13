<?php declare(strict_types=1);
    use App\Core\View;

    use App\Helpers\FlashMessage;
    use Symfony\Component\HttpFoundation\Response;

    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    $title = "Registra't";

    $register_errors = FlashMessage::get('register_errors');
    $info_form = FlashMessage::get('form');

    $content = View::render('register', 'default', compact('register_errors', 'info_form', 'title'));
    $response = new Response($content);
    $response->setStatusCode(Response::HTTP_OK);
    $response->send();
