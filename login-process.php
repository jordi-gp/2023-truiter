<?php declare(strict_types=1);
    require_once 'bootstrap.php';

    use App\Registry;

    use App\Helpers\Validator;
    use App\Helpers\FlashMessage;

    use App\Services\UserRepository;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    $request = Request::createFromGlobals();

    $request_method = $request->server->get('REQUEST_METHOD');
    if($request_method === "POST") {

    } else {
        $response = new RedirectResponse("login");
        $response->send();
    }