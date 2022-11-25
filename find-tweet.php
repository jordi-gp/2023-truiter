<?php
    session_start();
    require 'src/App/Helpers/FlashMessage.php';
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        # Connexió a la base de dades
        require_once "dbConnection.php";

        $value_search = "";
        $search_errors = [];

        if(!empty($_POST["tuit_search"])) {
            if(strlen($_POST["tuit_search"]) > 280) {
                $search_errors[] = "Un tuit no pot contindre més de 280 caracters";
            } else {
                $value_search = filter_var($_POST["tuit_search"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $search_errors[] = "No es pot realitzar una búsqueda sense indicar un valor";
        }

        if(empty($search_errors)) {
            $stmt = $pdo->prepare("SELECT * FROM tweet t INNER JOIN user u ON t.user_id = u.id
                                         LEFT JOIN media m ON t.id = m.tuit_id
                                         WHERE t.text LIKE :text ORDER BY t.created_at DESC");
            $stmt->bindValue(':text', "%$value_search%");
            $stmt->execute();

            $found_tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            unset($_SESSION["search_errors"]);

            require_once "views/found-tweet.view.php";
        } else {
            FlashMessage::set('search_errors', $search_errors);
            header("Location: index.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }