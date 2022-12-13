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

        # Obtenció dels repositoris utilitzats
        try {
            $userRepository = Registry::get(UserRepository::class);
            $validator = Registry::get(Validator::class);
        } catch (Exception $e) {
            die($e->getLine().": ".$e->getMessage());
        }

        # Nom
        $name = $request->get('name', '');
        try {
            Validator::lengthBetween($name, 2, 100, "Nom o contrasenya incorrectes");
        } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
            $register_errors[] = $err->getMessage();
        }
        $user_info["name"] = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);

        # Nom d'usuari
        $username = $request->get('username', '');
        try {
            Validator::lengthBetween($username, 2, 100, "Nom o contrasenya incorrectes");
        } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
            $register_errors[] = $err->getMessage();
        }
        $user_info["username"] = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);

        # Contrassenya
        $password = $request->get('password', '');
        try {
            Validator::lengthBetween($password, 2, 100, "Nom o contrasenya incorrectes");
        } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
            $register_errors[] = $err->getMessage();
        }
        $user_info["password"] = $password;

        # Contrassenya repetida
        $repeated_password = $request->get('repeated_password', '');
        try {
            Validator::lengthBetween($_POST["repeated_password"], 2, 100, "Nom o contrasenya incorrectes");
        } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
            $register_errors[] = $err->getMessage();
        }
        $user_info["repeated_password"] = $repeated_password;

        # Comprovació de que l'usuari indicat es troba registrat
        $registered_user = $userRepository->findByUsername($user_info["username"]);
        if($registered_user) {
            $register_errors[] = "Usuari o contrasenya incorrectes";
        }

        # Comprovació de la validació
        if(!empty($register_errors)) {
            FlashMessage::set("register_errors", $register_errors);
            FlashMessage::set("form", $user_info);

            $redirectResponse = new RedirectResponse('register');
        } else {
            $hashed_password = password_hash($user_info["repeated_password"], PASSWORD_DEFAULT);

            $user_to_add = new User($user_info["name"], $user_info["username"]);
            $user_to_add->setPassword($hashed_password);
            $created_at = DateTime::createFromFormat("Y-m-d h:i:s", $user_info["created_at"]);
            $user_to_add->setCreatedAt($created_at);

            $userRepository->save($user_to_add);

            $user_info["id"] = $user_to_add->getId();

            $_SESSION["logged"] = true;
            $_SESSION["user"] = $user_info;

            FlashMessage::set("info", $user_to_add->getUsername());

            unset($_SESSION["form"]);
            unset($_SESSION["register_error"]);

            $redirectResponse = new RedirectResponse('/');
        }
        $redirectResponse->send();
    } else {
        $redirectResponse = new RedirectResponse('register');
        $redirectResponse->send();
    }
