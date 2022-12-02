<?php declare(strict_types=1);
    use App\Helpers\FlashMessage;
    use App\Helpers\Validator;
    use App\Registry;
    use App\Services\UserRepository;

if($_SERVER["REQUEST_METHOD"] === "POST") {

        require_once 'bootstrap.php';
        require_once 'vendor/autoload.php';

        $userInf = $_SESSION["user"];
        $errors = [];
        $new_name = "";

        try {
            $userRepository = Registry::get(UserRepository::class);
            $validator = Registry::get(Validator::class);
        } catch (Exception $err) {
            echo $err->getLine()." ".$err->getMessage();
        }

        if(!empty($_POST["new_name"])) {
            try {
                $validator->lengthBetween($_POST["new_name"], 0, 100, "El nom no pot contindre més de 100 caracters");
            } catch (InvalidArgumentException $err) {
                $errors[] = "El nom indicat no es correcte";
            }

            $new_name = filter_var($_POST["new_name"], FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $errors[] = "El nom no pot estar en blanc!";
        }

        # Comprovació de que el nom no es igual
        if($new_name === $_POST["actual_name"])
            $errors[] = "El nom a actualitzar es el mateix que tens ja";

        if(empty($errors)) {
            $userRepository->updateName($userInf["id"], $new_name);

            $_SESSION["user"]["name"] = $new_name;

            unset($_SESSION["errors"]);

            # Missatge flash de confirmació per a l'usuari
            $flash_message = "El nom del compter s'ha canviat de forma correcta!";
            FlashMessage::set('confirm_message', $flash_message);

            header("Location: index.php");
        } else {
            FlashMessage::set('update_name_error', $errors);
            header("Location: edit-name.php");
        }
        exit();
    } else {
        header("Location: index.php");
        exit();
    }