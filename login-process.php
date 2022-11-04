<?php declare(strict_types=1);

    use App\User;
    require_once 'autoload.php';

    session_start();

    $isLogged = false;
    $errors = [];
    $info = [
        "username" => "",
        "password" => ""
    ];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
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

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["info"] = $info;
            header("Location: login.php");
        } else {
            $user = new User($info["username"], $info["username"]);
            $_SESSION["user"] = $user;
            $_SESSION["logged"] = true;
            $_SESSION["info"] = $info;
            unset($_SESSION["errors"]);
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: login.php");
        exit();
    }