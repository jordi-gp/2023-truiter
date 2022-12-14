<?php
    namespace App\Controller;
    use App\Core\View;

    use App\Helpers\Validator;
    use App\Registry;

    use App\Helpers\FlashMessage;

    use App\Services\UserRepository;
    use App\Services\TweetRepository;

    use App\User;
    use DateTime;
    use Exception;
    use PDOException;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    class DefaultController
    {
        public function index(Request $request):Response
        {
            $title = "Truiter una grollera cópia de Twitter";

            $tweetRepository = Registry::get(TweetRepository::class);
            $userRepository = Registry::get(UserRepository::class);
            $tweets = $tweetRepository->findAll();
            $users = $userRepository->findAll();

            $numOfTweets = count($tweets);
            $numOfUsers = count($users);

            $info = FlashMessage::get('info');
            $logout_message = FlashMessage::get('message');
            $confirm_message = FlashMessage::get('confirm_message');
            $search_errors = FlashMessage::get('search_errors');

            $content = View::render('index', 'default', compact('tweets', 'users', 'numOfTweets', 'numOfUsers', 'info', 'logout_message', 'confirm_message', 'search_errors', 'title'));
            return new Response($content);
        }

        public function login(Request $request):Response
        {
            $title = "Inici de Sessió";
            # En cas de no haver valor retorna un array buit per defecte
            $errors = FlashMessage::get('login_errors');
            $info = FlashMessage::get('username');

            $content = View::render('login', 'default', compact('errors', 'info', 'title'));
            return new Response($content);
        }

        public function login_process(Request $request):Response
        {
            $username = $request->get('username', '');
            $password = $request->get('password', '');

            $errors = [];

            try {
                $userRepository = Registry::get(UserRepository::class);
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
                $response = new RedirectResponse("login");
            } else {
                $_SESSION["logged"] = true;
                FlashMessage::set('info', $username);
                $_SESSION["user"] = $user;

                $logger->info("@".$username." ha iniciat sessió");
                unset($_SESSION["errors"]);
                $response = new RedirectResponse("/");
            }
            return $response;
        }

        public function register(Request $request):Response
        {
            $title = "Registra't";

            $register_errors = FlashMessage::get('register_errors');
            $info_form = FlashMessage::get('form');

            $content = View::render('register', 'default', compact('register_errors', 'info_form', 'title'));
            $response = new Response($content);
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        }

        public function register_process(Request $request):Response
        {
            # Obtenció dels repositoris utilitzats
            try {
                $userRepository = Registry::get(UserRepository::class);
            } catch (Exception $e) {
                die($e->getLine().": ".$e->getMessage());
            }

            # Nom
            $name = $request->get('name', '');
            try {
                Validator::lengthBetween($name, 2, 100, "Nom o contrasenya incorrectes");
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["name"] = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);

            # Nom d'usuari
            $username = $request->get('username', '');
            try {
                Validator::lengthBetween($username, 2, 100, "Nom o contrasenya incorrectes");
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["username"] = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);

            # Contrassenya
            $password = $request->get('password', '');
            try {
                Validator::lengthBetween($password, 2, 100, "Nom o contrasenya incorrectes");
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["password"] = $password;

            # Contrassenya repetida
            $repeated_password = $request->get('repeated_password', '');
            try {
                Validator::lengthBetween($_POST["repeated_password"], 2, 100, "Nom o contrasenya incorrectes");
            } catch (\App\Helpers\Exceptions\InvalidArgumentException $err) {
                $register_errors[] = $err->getMessage();
            }
            $user_info["repeated_password"] = $repeated_password;

            # Comprovació de que l'usuari indicat es troba registrat
            $registered_user = $userRepository->findByUsername($user_info["username"]);
            if($registered_user) {
                $register_errors[] = "Usuari o contrasenya incorrectes";
            }

            # Comprovació de la validació
            if(!empty($register_errors)) {
                FlashMessage::set("register_errors", $register_errors);
                FlashMessage::set("form", $user_info);

                $response = new RedirectResponse('register');
            } else {
                $hashed_password = password_hash($user_info["repeated_password"], PASSWORD_DEFAULT);

                $user_to_add = new User($user_info["name"], $user_info["username"]);
                $user_to_add->setPassword($hashed_password);
                $created_at = DateTime::createFromFormat("Y-m-d h:i:s", $user_info["created_at"]);
                $user_to_add->setCreatedAt($created_at);

                $userRepository->save($user_to_add);

                $user_info["id"] = $user_to_add->getId();

                $_SESSION["logged"] = true;
                $_SESSION["user"] = $user_info;

                FlashMessage::set("info", $user_to_add->getUsername());

                unset($_SESSION["form"]);
                unset($_SESSION["register_error"]);

                $response = new RedirectResponse('/');
            }
            return $response;
        }
    }