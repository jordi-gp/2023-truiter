<?php
// ací va la lògica per a processar el formulari de creació de tuits
    if(!isset($_SESSION)){
        session_start();
    }

    $isPost = false;
    $errors = [];
    $tuitValue = "";
    $tuitFile = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $isPost = true;



    } else {
        header("Location: tweet-new.php");
    }