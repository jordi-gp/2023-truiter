<?php declare(strict_types=1);
    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    use App\User;

    use App\Registry;

    use App\Helpers\Validator;
    use App\Helpers\FlashMessage;

    use App\Services\UserRepository;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    $register_errors = [];
    $user_info = [
        "id" => "",
        "name" => "",
        "username" => "",
        "password" => "",
        "repeated_password" => "",
        "created_at" => date("Y-m-d h:i:s")
    ];

    $request = Request::createFromGlobals();

    $request_method = $request->server->get('REQUEST_METHOD');
    if($request_method === "POST") {
        # Servici de connexió a la base de dades
        try {
            $db = Registry::get(Registry::DB);
        } catch (PDOException $err) {
            die($err->getLine().": ".$err->getMessage());
        }


        $redirectResponse->send();
    } else {
        $redirectResponse = new RedirectResponse('register');
        $redirectResponse->send();
    }
