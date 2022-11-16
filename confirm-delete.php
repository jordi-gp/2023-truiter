<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        session_start();

        //Connexió a la base de dades
        require_once 'dbConnection.php';

        $userInf = $_SESSION["user"];

        //Eliminació dels tuits de l'usuari
        $stmt = $pdo->prepare("DELETE FROM tweet WHERE user_id=:user_id");
        $stmt->bindValue(':user_id', $userInf["id"]);
        $stmt->execute();

        //Eliminació de l'usuari de la bbdd
        $stmt = $pdo->prepare("DELETE FROM user WHERE id=:id");
        $stmt->bindValue(':id', $userInf["id"]);
        $stmt->execute();

        unset($_SESSION["user"]);
        unset($_SESSION["logged"]);
        header("Location: index.php");
        exit();
    } else {
        header('Location: index.php');
        exit();
    }
