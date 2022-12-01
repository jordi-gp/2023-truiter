<?php declare(strict_types=1);
    require_once 'bootstrap.php';

    use App\Registry;
    use App\Helpers\Validator;
    use App\Helpers\FlashMessage;
    use App\Services\UserRepository;
use App\User;

    require_once 'vendor/autoload.php';

    $register_errors = [];
    $user_info = [
        "id" => "",
        "name" => "",
        "username" => "",
        "password" => "",
        "repeated_password" => "",
        "created_at" => ""
    ];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $db = Registry::get(Registry::DB);
        } catch (PDOException $err) {
            die($err->getLine().": ".$err->getMessage());
        }

        try {
            $userRepository = Registry::get(UserRepository::class);
            $validator = Registry::get(Validator::class);
        } catch (Exception $e) {
            die($e->getLine().": ".$e->getMessage());
        }

        # Validació del formulari
        if(!empty($_POST["name"])) {
            try {
                Validator::lengthBetween($_POST["name"], 0, 100, "Nom o contrasenya incorrectes");
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["name"] = filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $register_errors[] = "Nom o contrasenya incorrectes";
        }

        if(!empty($_POST["username"])) {
            try {
                Validator::lengthBetween($_POST["username"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["username"] = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $register_errors[] = "Nom o contrasenya incorrectes";
        }

        if(!empty($_POST["password"])) {
            try {
                Validator::lengthBetween($_POST["password"], 0, 100, "Nom o contrasenya incorrectes");
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["password"] = $_POST["password"];
        } else {
            $register_errors[] = "Nom o contrasenya incorrectes";
        }

        if(!empty($_POST["repeated_password"])) {
            try {
                Validator::lengthBetween($_POST["repeated_password"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["repeated_password"] = $_POST["repeated_password"];
        } else {
            $register_errors[] = "Nom o contrasenya incorrectes";
        }

        # Comprovació de la validació
        if(!empty($register_errors)) {
            FlashMessage::set("register_errors", $register_errors);
            FlashMessage::set("form", $user_info);

            header("Location: register.php");
        } else {
            $hashed_password = password_hash($user_info["repeated_password"], PASSWORD_DEFAULT);

            $user_to_add = new User($user_info["name"], $user_info["username"]);
            $registered_user = $userRepository->findByUsername($user_info["username"]);
            if($registered_user) {
                $register_errors[] = "Usuari o contrasenya incorrectes";
            }
            $user_to_add->setPassword($hashed_password);
            $user_to_add->setCreatedAt(new DateTime());

            $userRepository->save($user_to_add);

            $_SESSION["logged"] = true;
            $_SESSION["user"] = $user_info;

            FlashMessage::set("info", $user_info);

            unset($_SESSION["form"]);
            unset($_SESSION["register_error"]);

            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: register.php");
        exit();
    }
