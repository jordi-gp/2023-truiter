<?php declare(strict_types=1);

    /*
     * Script per afegir uns quants tuits per defecte a la base de dades
    */

    //Connexió a la bbdd
    require_once('dbConnection.php');

    //Creació dels usuaris
    $created_at = Date("Y-m-d");
    $tuits[] = [
        "text" => "Por la cerveza: causa y solución de todos los problemas",
        "created_at" => $created_at,
        "like_count" => 0
    ];

    $tuits[] = [
        "text" => "Si algo hemos aprendido de los Picapiedra es que los pelícanos sirven para mezclar cemento",
        "created_at" => $created_at,
        "like_count" => 0
    ];

    $tuits[] = [
        "text" => "¡Ay, caramba!",
        "created_at" => $created_at,
        "like_count" => 0
    ];

    //Obtenció dels id's dels usuaris
    try {
        $stmt = $pdo->prepare("SELECT id FROM user");
        $stmt->execute();
        $userIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $err) {
        $err->getMessage();
    }

    //Inserció de tuits
    try {
        $numOfUsers = count($userIds)-1;
        $stmt = $pdo->prepare("INSERT INTO tweet(text, created_at, like_count, user_id) VALUES (:text, :created_at, :like_count, :user_id)");
        foreach($tuits as $tuit) {
            $userId = rand(0, $numOfUsers);
            $stmt->bindValue(':text', $tuit["text"]);
            $stmt->bindValue(':created_at', $created_at);
            $stmt->bindValue(':like_count', $tuit["like_count"]);
            $stmt->bindValue(':user_id', $userIds[$userId]["id"]);
            //$stmt->execute();
        }
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
