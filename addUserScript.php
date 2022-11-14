<?php declare(strict_types=1);

    /*
     * Script per afegir uns quants usuaris per defecte a la base de dades
    */

    //Connexió a la bbdd
    require_once('dbConnection.php');

    //Creació dels usuaris
    $created_at = Date("Y-m-d");
    $password1 = password_hash("cerveza1234", PASSWORD_DEFAULT);
    $password2 = password_hash("1234", PASSWORD_DEFAULT);
    $usuaris[] = [
        "name"=> "Homer",
        "username" => "homero",
        "password" => $password1,
        "created_at" => $created_at,
        "verified" => 0
    ];

    $usuaris[] = [
        "name"=> "Bart",
        "username" => "bartolomeo",
        "password" => $password2,
        "created_at" => $created_at,
        "verified" => 0
    ];

    //Inserció d'usuaris
    try {
        $stmt = $pdo->prepare("INSERT INTO user(name, username, password, created_at, verified) VALUES (:name, :username, :password, :created_at, :verified)");
        foreach($usuaris as $user) {
            $stmt->bindValue(':name', $user["name"]);
            $stmt->bindValue(':username', $user["username"]);
            $stmt->bindValue('password', $user["password"]);
            $stmt->bindValue('created_at', $user["created_at"]);
            $stmt->bindValue('verified', $user["verified"]);
            //$stmt->execute();
        }
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
