<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        session_start();

        //Connexió a la base de dades
        require_once 'dbConnection.php';

        $userInf = $_SESSION["user"];
        $errors = [];
        $new_username = "";

        if(!empty($_POST["new_username"])) {
            if(strlen($_POST["new_username"]) > 100) {
                $errors[] = "El nom d'usuari no pot contindre més de 100 caracters";
            } else {
                $stmt = $pdo->prepare("SELECT username FROM user");
                $stmt->execute();
                $registered_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($registered_users as $reg_user) {
                    if($reg_user["username"] === $_POST["new_username"]) {
                        $errors[] = "El nom d'usuari indicat ja es troba registrat";
                    } else {
                        $new_username = filter_var($_POST["new_username"], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        } else {
            $errors[] = "El nom d'usuari no pot estar en blanc!";
        }

        if(empty($errors)) {
            $stmt = $pdo->prepare("UPDATE user SET username=:new_username WHERE id=:user_id");
            $stmt->bindValue('new_username', $new_username);
            $stmt->bindValue('user_id', $userInf["id"]);
            $stmt->execute();
            $_SESSION["user"]["username"] = $new_username;

            //Eliminació d'errors del formulari
            unset($_SESSION["errors"]);

            //Missatge flash de confirmació per a l'usuari
            $flash_message = "El nom d'usuari s'ha canviat de forma correcta!";
            $_SESSION["message"] = $flash_message;

            header("Location: index.php");
            exit();
        } else {
            $_SESSION["errors"] = $errors;
            header("Location: edit-username.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }