<?php declare(strict_types=1);
    require_once 'bootstrap.php';
    use App\Helpers\FlashMessage;
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
            echo $err->getMessage()." ".$err->getLine();
            //die($err->getLine().": ".$err->getMessage());
        }



        //Validació del formulari
        if(!empty($_POST["username"])) {
            if(strlen($_POST["username"]) > 100) {
                $errors[] = "El nom no pot contindre més de 100 caracters";
            } else {
                $info["username"] = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $errors[] = "El camp d'usuari no pot estar buit";
        }

        if(!empty($_POST["password"])) {
            if(strlen($_POST["password"]) > 100) {
                $errors[] = "La contrasenya no pot contindre més de 100 caracters";
            } else {
                $info["password"] = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $errors[] = "S'ha d'introduïr una contrasenya";
        }

        try {
            $user = $userRepository->findUsername($info["username"]);

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