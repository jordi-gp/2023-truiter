<?php declare(strict_types=1);
    require_once 'bootstrap.php';
    use App\Helpers\FlashMessage;
use App\Helpers\Validator;
use App\Registry;
    use App\Services\UserRepository;

    $errors = [];
    $info = [
        "username" => "",
        "password" => ""
    ];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $db = Registry::get(Registry::DB);
            $userRepository = Registry::get(UserRepository::class);
        } catch (PDOException $err) {
            die($err->getLine().": ".$err->getMessage());
        }

        try {
            $validator = Registry::get(Validator::class);
        } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
            echo $e->getline()." ".$e->getMessage();
        }

        //Validació del formulari
        if(!empty($_POST["username"])) {
            try {
                $validator->lengthBetween($_POST["username"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
                $errors[] = $e->getMessage();
            }

            $info["username"] = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $errors[] = "El camp d'usuari no pot estar buit";
        }

        if(!empty($_POST["password"])) {
            try {
                $validator->lengthBetween($_POST["password"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
                $errors[] = $e->getMessage();
            }

            $info["password"] = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $errors[] = "S'ha d'introduïr una contrasenya";
        }

        try {
            $user = $userRepository->findByUsername($info["username"]);

            # Comprovació de que l'usuari existeix a la base de dades
            if(!$user) {
                $errors[] = "L'usuari indicat no es troba registrat!";
            } else {
                if(!password_verify($info["password"], $user["password"])) {
                    $errors[] = "La contrasenya indicada no es correcta!";
                }
            }
        } catch (PDOException $err) {
            echo $err->getMessage();
        }

        if(!empty($errors)) {
            FlashMessage::set("login_errors", $errors);
            FlashMessage::set("username", $info);
            header("Location: login.php");
        } else {
            $_SESSION["logged"] = true;
            FlashMessage::set('info', $info);
            $_SESSION["user"] = $user;
            unset($_SESSION["errors"]);
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: login.php");
        exit();
    }