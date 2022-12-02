<?php declare(strict_types=1);


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

        $user_inf = FlashMessage::get('user');
        $errors = [];
        $new_username = "";

        if(!empty($_POST["new_username"])) {

            try {
                $validator->lengthBetween($_POST["new_username"], 0, 100, "Nom d'usuari incorrecte");
            } catch (Exception $err) {
                $errors[] = "Nom d'usuari incorrecte";
            }

            # Comprovació de que l'usuari indicat es troba registrat
            $registered_user = $userRepository->findByUsername($_POST["new_username"]);
            if($registered_user) {
                $register_errors[] = "Usuari o contrasenya incorrectes";
            }
        } else {
            $errors[] = "El nom d'usuari no pot estar en blanc!";
        }

        if(empty($errors)) {
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