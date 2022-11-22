<?php declare(strict_types=1);
    session_start();
    require_once 'src/App/Helpers/FlashMessage.php';

    $register_error = FlashMessage::get('register_errors');
    $info_form = FlashMessage::get('form');

    require_once 'views/register.view.php';
