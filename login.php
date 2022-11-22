<?php declare(strict_types=1);
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    var_dump($_SESSION["flash-message"]);
    # En cas de no haver valor retorna un array buit per defecte
    $errors = FlashMessage::get('errors');
    $info = FlashMessage::get('username');

    require 'views/login.view.php';