<?php declare(strict_types=1);
    use App\User;
    require_once 'autoload.php';
    session_start();
    require_once('dbConnection.php');

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

        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE username=:username");
            $stmt->bindValue(':username', $info["username"]);
            $stmt->execute();

            //Comprovació de que l'usuari existeix a la base de dades
            if($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!password_verify($info["password"], $user["password"])) {
                    $errors[] = "La contrasenya indicada no es correcta!";
                } else {
                    $user = new User($user["name"], $user["username"]);
                    $_SESSION["logged"] = true;
                    unset($_SESSION["errors"]);
                    header("Location: index.php");
                    exit();
                }
            } else {
                $errors[] = "L'usuari indicat no es troba registrat!";
            }
        } catch (PDOException $err) {
            echo $err->getMessage();
        }

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["info"] = $info;
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
        exit();
    }