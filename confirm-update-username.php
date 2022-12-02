<?php declare(strict_types=1);
    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    use App\Helpers\FlashMessage;
    use App\Helpers\Validator;
    use App\Registry;
    use App\Services\UserRepository;


    if($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            $userRepository = Registry::get(UserRepository::class);
            $validator = Registry::get(Validator::class);
        } catch (Exception $err) {
            echo $err->getLine()." ".$err->getMessage();
        }

        $user_inf = $_SESSION["user"];
        $errors = [];
        $actual_name = $_SESSION["user"]["username"];
        $new_username = "";

        if(!empty($_POST["new_username"])) {
            try {
                $validator->lengthBetween($_POST["new_username"], 0, 100, "Nom d'usuari incorrecte");
            } catch (Exception $err) {
                $errors[] = "Nom d'usuari incorrecte";
            }

            $registered_username = $userRepository->findByUsername($_POST["new_username"]);

            if($actual_name === $_POST["new_username"]) {
                $errors[] = "No es pot actualitzar amb el mateix nom";
            } else if($registered_username) {
                $errors[] = "Nom d'usuari incorrecte";
            } else {
                $new_username = filter_var($_POST["new_username"], FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else {
            $errors[] = "El nom d'usuari no pot estar en blanc!";
        }

        if(empty($errors)) {
            var_dump($user_inf);
            $userRepository->updateUsername($user_inf["id"], $new_username);

            $_SESSION["user"]["username"] = $new_username;

            unset($_SESSION["errors"]);

            # Missatge flash de confirmació per a l'usuari
            $flash_message = "El nom d'usuari s'ha canviat de forma correcta!";
            FlashMessage::set('confirm_message', $flash_message);

            header("Location: index.php");
        } else {
            FlashMessage::set('update_username_errors', $errors);
            header("Location: edit-username.php");
        }
        exit();
    } else {
        header("Location: index.php");
        exit();
    }