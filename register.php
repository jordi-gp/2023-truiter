<?php declare(strict_types=1);
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    # En cas de no haver valor retorna un array buit per defecte
    $register_error = FlashMessage::get('register_errors');
    $info = FlashMessage::get('form');

    require_once 'views/register.view.php';
