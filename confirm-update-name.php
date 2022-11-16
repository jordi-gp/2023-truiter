<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        session_start();

        //Connexió a la base de dades
        require_once 'dbConnection.php';

        $userInf = $_SESSION["user"];
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
            $_SESSION["user"]["name"] = $new_name;
            unset($_SESSION["errors"]);
            header("Location: index.php");
            exit();
        } else {
            $_SESSION["errors"] = $errors;
            header("Location: edit-name.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }