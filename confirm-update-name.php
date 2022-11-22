<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        session_start();
        require_once 'src/App/Helpers/FlashMessage.php';

        # Connexió a la base de dades
        require_once 'dbConnection.php';

        $userInf = FlashMessage::get('user');
        $errors = [];
        $new_name = "";

        if(!empty($_POST["new_name"])) {
            if(strlen($_POST["new_name"]) > 100) {
                $errors[] = "El nom no pot contindre més de 100 caracters";
            } else {
                $new_name = filter_var($_POST["new_name"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $errors[] = "El nom no pot estar en blanc!";
        }

        if(empty($errors)) {
            $stmt = $pdo->prepare("UPDATE user SET name=:new_name WHERE id=:user_id");
            $stmt->bindValue('new_name', $new_name);
            $stmt->bindValue('user_id', $userInf["id"]);
            $stmt->execute();
            $userInf["name"] = $new_name;

            # Eliminació d'errors del formulari
            unset($_SESSION["errors"]);

            //Missatge flash de confirmació per a l'usuari
            $flash_message = "El nom del compter s'ha canviat de forma correcta!";
            FlashMessage::set('confirm_message', $flash_message);
            header("Location: index.php");
            exit();
        } else {
            FlashMessage::set('update_name_error', $errors);
            header("Location: edit-name.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }