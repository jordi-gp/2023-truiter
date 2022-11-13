<?php declare(strict_types=1);

    /*
     * Script per afegir uns quants tuits per defecte a la base de dades
    */

    //Connexió a la bbdd
    $dsn = "mysql:host=localhost; dbname=truiter";
    $user = "root";
    $password = "";
    try {
        $pdo = new PDO($dsn, $user, $password);
    } catch (PDOException $err) {
        echo $err->getMessage();
    }

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

    //Inserció de tuits
    try {
        $stmt = $pdo->prepare("INSERT INTO tweet(text, created_at, like_count) VALUES (:text, :created_at, :like_count)");
        foreach($tuits as $tuit) {
            $stmt->bindValue(':text', $tuit["text"]);
            $stmt->bindValue(':created_at', $created_at);
            $stmt->bindValue('like_count', $tuit["like_count"]);
            //$stmt->execute();
        }
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
