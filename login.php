<?php declare(strict_types=1);
    use App\Core\View;

    use App\Helpers\FlashMessage;
    use Symfony\Component\HttpFoundation\Response;

    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    $title = "Inici de Sessió";
    # En cas de no haver valor retorna un array buit per defecte
    $errors = FlashMessage::get('login_errors');
    $info = FlashMessage::get('username');

    $content = View::render('login', 'default', compact('errors', 'info', 'title'));
    $response = new Response($content);
    $response->setStatusCode(Response::HTTP_OK);
    $response->send();