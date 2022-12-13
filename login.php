<?php declare(strict_types=1);
    use App\Core\View;

    use App\Helpers\FlashMessage;

    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    $title = "Inici de Sessió";
    # En cas de no haver valor retorna un array buit per defecte
    $errors = FlashMessage::get('login_errors');
    $info = FlashMessage::get('username');

    echo View::render('login', 'default', compact('errors', 'info', 'title'));