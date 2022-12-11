<?php
    require 'bootstrap.php';
    use App\Core\View;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        echo View::render('delete-user', 'default');
    } else {
        header('Location: index.php');
        exit();
    }
