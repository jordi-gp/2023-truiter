<?php declare(strict_types=1);
    //Connexió a la bbdd
    $dsn = "mysql:host=localhost; dbname=truiter";
    $user = "root";
    $password = "";
    try {
        $pdo = new PDO($dsn, $user, $password);
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
