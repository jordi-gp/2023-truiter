<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Connexió a la base de dades
        require_once "dbConnection.php";

        $value_search = "";
        $search_errors = [];

        if(!empty($_POST["tuit_search"])) {
            if(strlen($_POST["tuit_search"]) > 280) {
                $search_errors[] = "Un tuit no pot contindre més de 280 caracters";
            } else {
                $value_search = $_POST["tuit_search"];
            }
        } else {
            $search_errors[] = "No es pot realitzar una búsqueda sense indicar un valor";
        }

        if(empty($search_errors)) {
            $stmt = $pdo->prepare("SELECT * FROM tweet t INNER JOIN user u ON t.user_id = u.id
                                        LEFT JOIN media m ON t.id = m.tuit_id
                                        ORDER BY t.created_at DESC WHERE t.text LIKE '%:text%'");
            $stmt->bindValue(':text', $value_search);
            $stmt->execute();

            var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

            unset($_SESSION["search_errors"]);
        } else {
            $_SESSION["search_errors"] = $search_errors;
            header("Location: index.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }