<?php

    namespace App\Controller;

    use App\Core\View;
    use App\Helpers\FlashMessage;
    use App\Helpers\Validator;
    use App\Registry;
    use App\Services\PhotoRepository;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;
    use Exception;
    use InvalidArgumentException;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    class UserController
    {
        public function profile(Request $request):Response
        {
            if(!isset($_SESSION["logged"])) {
                return new RedirectResponse('/');
            } else {
                $user = $_SESSION["user"];
                $name = $user["name"];
                $username = $user["username"];

                $content = View::render('profile', 'default', compact('username', 'name'));
                return new Response($content);
            }
        }

        public function edit_name(Request $request):Response
        {
            if(!isset($_SESSION["logged"])) {
                return new RedirectResponse('/');
            } else {
                # Informació de l'usuari
                $userInfo = $_SESSION["user"];
                $name = $userInfo["name"];

                # Errors del formulari
                $errors = FlashMessage::get('update_name_error');

                $content = View::render('edit-name', 'default', compact('name', 'errors'));
                return new Response($content);
            }
        }

        public function confirm_update_name(Request $request):Response
        {
            $userInf = $_SESSION["user"];
            $errors = [];
            $actual_name = $request->get('actual_name', '');

            try {
                $userRepository = Registry::get(UserRepository::class);
            } catch (Exception $err) {
                echo $err->getLine()." ".$err->getMessage();
            }

            $new_name = $request->get('new_name', '');
            try {
                Validator::lengthBetween($new_name, 2, 100, "El nom no pot contindre més de 100 caracters");
            } catch (InvalidArgumentException $err) {
                $errors[] = "El nom indicat no es correcte";
            }
            $validated_name = filter_var($new_name, FILTER_SANITIZE_SPECIAL_CHARS);

            # Comprovació de que el nom no es igual
            if($validated_name === $actual_name)
                $errors[] = "El nom a actualitzar es el mateix que tens ja";

            if(empty($errors)) {
                $userRepository->updateName($userInf["id"], $validated_name);

                $_SESSION["user"]["name"] = $validated_name;

                unset($_SESSION["errors"]);

                # Missatge flash de confirmació per a l'usuari
                $flash_message = "El nom del compter s'ha canviat de forma correcta!";
                FlashMessage::set('confirm_message', $flash_message);

                return new RedirectResponse('/');
            } else {
                FlashMessage::set('update_name_error', $errors);
                return new RedirectResponse('edit-name');
            }
        }

        public function edit_username(Request $request):Response
        {
            if(!isset($_SESSION["logged"])) {
                header("Location: index.php");
                exit();
            } else {
                # Informació de l'usuari
                $userInfo = $_SESSION["user"];
                $username = $userInfo["username"];

                # Errors del formulari
                $errors = FlashMessage::get('update_username_errors');

                $content = View::render('edit-username', 'default', compact('username', 'errors'));
                return new Response($content);
            }
        }

        public function confirm_update_username(Request $request):Response
        {
            try {
                $userRepository = Registry::get(UserRepository::class);
            } catch (Exception $err) {
                echo $err->getLine()." ".$err->getMessage();
            }

            $user_inf = $_SESSION["user"];
            $errors = [];
            $actual_name = $_SESSION["user"]["username"];
            $new_username = $request->get('new_username');

            try {
                Validator::lengthBetween($new_username, 2, 100, "Nom d'usuari incorrecte");
            } catch (Exception $err) {
                $errors[] = "Nom d'usuari incorrecte";
            }
            $registered_username = $userRepository->findByUsername($new_username);

            if($actual_name === $new_username) {
                $errors[] = "No es pot actualitzar amb el mateix nom";
            } else if($registered_username) {
                $errors[] = "Nom d'usuari incorrecte";
            } else {
                $validated_username = filter_var($new_username, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            if(empty($errors)) {
                $userRepository->updateUsername($user_inf["id"], $validated_username);

                $_SESSION["user"]["username"] = $validated_username;

                unset($_SESSION["errors"]);

                # Missatge flash de confirmació per a l'usuari
                $flash_message = "El nom d'usuari s'ha canviat de forma correcta!";
                FlashMessage::set('confirm_message', $flash_message);

                return new RedirectResponse('/');
            } else {
                FlashMessage::set('update_username_errors', $errors);
                return new RedirectResponse('edit-username');
            }
        }

        public function delete_user(Request $request):Response
        {
            if(!isset($_SESSION["logged"])) {
                return new RedirectResponse('/');
            } else {
                $content = View::render('delete-user', 'default');
                return new Response($content);
            }
        }

        public function confirm_delete_user(Request $request):Response
        {
            $decision = $request->get('decision');

            if($decision === 'delete') {
                $userInf = $_SESSION["user"];
                try {
                    $tweet_repository = Registry::get(TweetRepository::class);
                    $user_repository = Registry::get(UserRepository::class);
                    $photo_repository = Registry::get(PhotoRepository::class);
                } catch (Exception $err) {
                    die($err->getLine() . " " . $err->getMessage());
                }

                # Obtenció dels tuits amb imatge de l'usuari
                $tweetMedia = $photo_repository->selectMedia($userInf["id"]);


                $photo_repository->deleteMedia($tweetMedia["tuit_id"]);

                # Eliminació dels tuits de l'usuari
                $tweet_repository->deleteTweetsFromUser($userInf["id"]);

                # Eliminació de l'usuari de la bbdd
                $user_repository->deleteUserById($userInf["id"]);

                # Missatge flash de confirmació per a l'usuari
                $flash_message = "L'usuari s'ha eliminat de forma correcta!";
                FlashMessage::set('confirm_message', $flash_message);

                session_unset();
                session_destroy();
            }
            #return new RedirectResponse('/');
        }
    }