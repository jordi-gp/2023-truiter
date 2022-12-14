<?php declare(strict_types=1);
    use App\Core\View;

    use App\Helpers\FlashMessage;
    use Symfony\Component\HttpFoundation\Response;

    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';


    $response->setStatusCode(Response::HTTP_OK);
    $response->send();
