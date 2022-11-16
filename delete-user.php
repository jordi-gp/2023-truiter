<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        require 'views/delete-user.view.php';
    } else {
        header('Location: index.php');
        exit();
    }
