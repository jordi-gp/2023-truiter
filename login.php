<?php declare(strict_types=1);
    session_start();
    require_once 'autoload.php';
    require_once 'src/App/Helpers/FlashMessage.php';

    # En cas de no haver valor retorna un array buit per defecte
    $errors = FlashMessage::get('login_errors');
    $info = FlashMessage::get('username');

    require 'views/login.view.php';