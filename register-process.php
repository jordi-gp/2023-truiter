<?php declare(strict_types=1);
    session_start();
    require_once('dbConnection.php');

    $register_errors = [];
    $user_info = [
        "name" => "",
        "username" => "",
        "password" => "",
        "repeated_password" => "",
        "created_at" => ""
    ];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Validació del formulari
        if(!empty($_POST["name"])) {
            if(strlen($_POST["name"]) > 100) {
                $register_errors[] = "El nom no pot contindre més de 100 caràcters";
            } else {
                $user_info["name"] = filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $register_errors[] = "S'ha d'introduïr un nom!";
        }

        if(!empty($_POST["username"])) {
            if(strlen($_POST["username"]) > 100) {
                $register_errors[] = "El nom d'usuari no pot superar els 100 caràcters";
            } else {
                $stmt = $pdo->prepare("SELECT username FROM user");
                $stmt->execute();
                $registered_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($registered_users as $reg_user) {
                    if($reg_user["username"] === $_POST["username"]) {
                        $register_errors[] = "El nom d'usuari proporcionat ja es troba registrat";
                    } else {
                        $user_info["username"] = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        } else {
            $register_errors[] = "S'ha de proporcionar un nom d'usuari";
        }

        if(!empty($_POST["password"])) {
            if(strlen($_POST["password"]) > 100) {
                $register_errors[] = "La contrasenya no pot contindre més de 100 caràcters";
            } else {
                $user_info["password"] = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $register_errors[] = "S'ha d'introduïr una contrasenya";
        }

        if(!empty($_POST["repeated_password"])) {
            if(strlen($_POST["repeated_password"]) > 100) {
                $register_errors[] = "La contrasenya no pot contindre més de 100 caràcters";
            } else if($_POST["password"] != $_POST["repeated_password"]) {
                $register_errors[] = "Les contrasenyes han de coincidir";
            } else {
                $user_info["repeated_password"] = filter_var($_POST["repeated_password"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $register_errors[] = "S'ha de tornar a introduïr la contrasenya";
        }

        //Comprovació de la validació
        if(!empty($register_errors)) {
            $_SESSION["register_error"] = $register_errors;
            $_SESSION["form"] = $user_info;
            header("Location: register.php");
        } else {
            $verified = 0;
            $hashed_password = password_hash($user_info["repeated_password"], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user(name, username, password, created_at, verified) VALUES (:name, :username, :password, :created_at, :verified)");
            $stmt->bindValue('name', $user_info["name"]);
            $stmt->bindValue('username', $user_info["username"]);
            $stmt->bindValue('password', $hashed_password);
            $stmt->bindValue('created_at', $user_info["created_at"]);
            $stmt->bindValue('verified', $verified);
            $stmt->execute();

            $_SESSION["logged"] = true;
            $_SESSION["info"] = $user_info;
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
