<?php declare(strict_types=1);
    use App\Helpers\FlashMessage;
    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    $register_error = FlashMessage::get('register_errors');
    $info_form = FlashMessage::get('form');

    require_once 'views/register.view.php';
