<?php declare(strict_types=1);
    session_start();

    use App\Helpers\Validator;

    require_once 'autoload.php';
    require_once 'dbConnection.php';
    require_once 'src/App/Helpers/FlashMessage.php';

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
        # Validació del formulari
        if(!empty($_POST["name"])) {
            try {
                Validator::lengthBetween($_POST["name"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["name"] = filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $register_errors[] = "S'ha d'indicar un nom";
        }

        if(!empty($_POST["username"])) {
            try {
                Validator::lengthBetween($_POST["username"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["username"] = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $register_errors[] = "S'ha d'indicar un nom d'usuari";
        }

        if(!empty($_POST["password"])) {
            try {
                Validator::lengthBetween($_POST["password"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["password"] = $_POST["password"];
        } else {
            $register_errors[] = "S'ha d'indicar una contrasenya";
        }

        if(!empty($_POST["repeated_password"])) {
            try {
                Validator::lengthBetween($_POST["repeated_password"], 0, 100);
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["repeated_password"] = $_POST["repeated_password"];
        } else {
            $register_errors[] = "S'ha de repetir la mateixa contrasenya";
        }

        # Comprovació de la validació
        if(!empty($register_errors)) {
            FlashMessage::set("register_errors", $register_errors);
            FlashMessage::set("form", $user_info);
            header("Location: register.php");
        } else {
            $verified = 0;
            $hashed_password = password_hash($user_info["repeated_password"], PASSWORD_DEFAULT);
            $created_at = (new DateTime())->format("Y-m-d");
            $stmt = $pdo->prepare("INSERT INTO user(name, username, password, created_at, verified) VALUES (:name, :username, :password, :created_at, :verified)");
            $stmt->bindValue('name', $user_info["name"]);
            $stmt->bindValue('username', $user_info["username"]);
            $stmt->bindValue('password', $hashed_password);
            $stmt->bindValue('created_at', $created_at);
            $stmt->bindValue('verified', $verified);
            $stmt->execute();

            $user_info["id"] = $pdo->lastInsertId();
            $_SESSION["logged"] = true;
            FlashMessage::set("info", $user_info);
            $_SESSION["user"] = $user_info;
            unset($_SESSION["form"]);
            unset($_SESSION["register_error"]);
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: register.php");
        exit();
    }
