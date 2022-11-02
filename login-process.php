<?php declare(strict_types=1);
    if(!isset($_SESION)) {
        session_start();
    }

    $isLogged = false;
    $errors = [];
    $info = [
        "username" => "",
        "password" => ""
    ];

    $isPost = false;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $isPost = true;
    }

    if($isPost) {
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
            exit();
        } else {
            header("Location: index.php");
            $_SESSION["logged"] = true;
            unset($_SESSION["errors"]);
            $_SESSION["info"] = $info;
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }