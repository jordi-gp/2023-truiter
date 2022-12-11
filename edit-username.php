<?php
    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    use App\Core\View;

    use App\Helpers\FlashMessage;

    if(!isset($_SESSION["logged"])) {
        header("Location: index.php");
        exit();
    } else {
        # Informació de l'usuari
        $userInfo = $_SESSION["user"];
        $username = $userInfo["username"];

        # Errors del formulari
        $errors = FlashMessage::get('update_username_errors');

        echo View::render('edit-username', 'default', compact('username', 'errors'));
    }