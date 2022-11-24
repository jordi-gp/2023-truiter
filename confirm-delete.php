<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        require_once 'src/App/Helpers/FlashMessage.php';

        session_start();

        //Connexió a la base de dades
        require_once 'dbConnection.php';

        $userInf = $_SESSION["user"];
        var_dump($userInf);

        //Obtenció dels tuits amb imatge de l'usuari
        $stmt = $pdo->prepare("SELECT * FROM tweet t INNER JOIN media m ON t.id=m.tuit_id WHERE user_id=:user_id");
        $stmt->bindValue(':user_id', $userInf["id"]);
        $stmt->execute();
        $tuitIds = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("DELETE FROM media WHERE tuit_id=:tuit_id");
        foreach($tuitIds as $tuit_id) {
            $stmt->bindValue(':tuit_id', $tuit_id["tuit_id"]);
            $stmt->execute();
        }

        //Eliminació dels tuits de l'usuari
        $stmt = $pdo->prepare("DELETE FROM tweet WHERE user_id=:user_id");
        $stmt->bindValue(':user_id', $userInf["id"]);
        $stmt->execute();

        //Eliminació de l'usuari de la bbdd
        $stmt = $pdo->prepare("DELETE FROM user WHERE id=:id");
        $stmt->bindValue(':id', $userInf["id"]);
        $stmt->execute();

        //Missatge flash de confirmació per a l'usuari
        $flash_message = "L'usuari s'ha eliminat de forma correcta!";
        FlashMessage::set('confirm_message', $flash_message);
        unset($_SESSION["user"]);
        unset($_SESSION["logged"]);
        header("Location: index.php");
        exit();
    } else {
        header('Location: index.php');
        exit();
    }
