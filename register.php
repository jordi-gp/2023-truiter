<?php declare(strict_types=1);
    use App\Core\View;

    use App\Helpers\FlashMessage;

    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    $register_error = FlashMessage::get('register_errors');
    $info_form = FlashMessage::get('form');

    echo View::render('register', 'default', compact('register_error', 'info_form'));
