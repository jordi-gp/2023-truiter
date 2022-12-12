<?php declare(strict_types=1);
    require_once 'bootstrap.php';

    use App\User;
    use App\Registry;

    use App\Helpers\Validator;
    use App\Helpers\FlashMessage;

    use App\Services\UserRepository;

    use Symfony\Component\HttpFoundation\RedirectResponse;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $errors = [];

        try {
            $db = Registry::get(Registry::DB);
        } catch (PDOException $err) {
            die($err->getLine().": ".$err->getMessage());
        }

        try {
            $userRepository = Registry::get(UserRepository::class);
            $validator = Registry::get(Validator::class);
            $logger = Registry::get("logger");
        } catch (Exception $e) {
            die($e->getLine().": ".$e->getMessage());
        }

        # Validació del formulari
        if(empty($username) || empty($password)) {
            $errors[] = "El nom d'usuari o la contrasenya no son correctes";
        } else {
            try {
                $user = $userRepository->findByUsername($username);
                # Comprovació que l'usuari existeix a la base de dades
                if(!$user) {
                    $errors[] = "El nom d'usuari o la contrasenya no son correctes";
                }
            } catch (PDOException $err) {
                echo $err->getMessage();
            }
        }

        if(!empty($errors)) {
            FlashMessage::set("login_errors", $errors);
            FlashMessage::set("username", $username);
            $response = new RedirectResponse("login.php");
        } else {
            $_SESSION["logged"] = true;
            FlashMessage::set('info', $username);
            $_SESSION["user"] = $user;

            $logger->info("@".$username." ha iniciat sessió");
            unset($_SESSION["errors"]);
            $response = new RedirectResponse("index.php");
        }
        $response->send();
    } else {
        $response = new RedirectResponse("login.php");
        $response->send();
    }