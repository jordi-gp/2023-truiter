<?php
    require_once 'autoload.php';
    use App\Photo;
    use App\Tweet;
    use App\Twitter;
    use App\User;
    use App\Video;
    session_start();
    if(!empty($_SESSION["info"])) {
        $info = $_SESSION["info"];
        unset($_SESSION["info"]);
    }

    //Connexió a la base de dades
    require_once('dbConnection.php');
    try {
        $stmt = $pdo->prepare("SELECT * FROM user");
        $stmt->execute();
        $numOfUsers = $stmt->rowCount();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $err) {
        echo $err->getMessage();
    }

    //Obtenció de tweets de la bbdd
    try {
        $stmt = $pdo->prepare("SELECT * FROM tweet t INNER JOIN user u ON t.user_id = u.id ORDER BY t.created_at DESC");
        $stmt->execute();
        $numOfTuits = $stmt->rowCount();
        $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $err) {
        echo $err->getMessage();
    }

    require 'views/index.view.php';
