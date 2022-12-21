<?php
    namespace App\Controller;

    use App\Core\View;

    use App\Helpers\Validator;
    use App\Registry;

    use App\Helpers\FlashMessage;

    use App\Services\PhotoRepository;
    use App\Services\TwitterDateFormat;
    use App\Services\UserRepository;
    use App\Services\TweetRepository;

    use App\User;
    use DateTime;
    use Exception;
    use InvalidArgumentException;
    use PDOException;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\RedirectResponse;

    class DefaultController
    {
        public function index(Request $request):Response
        {
            $title = "Truiter una grollera cópia de Twitter";

            $dateFormat = new TwitterDateFormat();
            $dateFormat->format();

            $tweetRepository = Registry::get(TweetRepository::class);
            $userRepository = Registry::get(UserRepository::class);
            $tweets = $tweetRepository->findAll();
            $users = $userRepository->findAll();

            $numOfTweets = count($tweets);
            $numOfUsers = count($users);

            # Formatat de la data
            $data = date('h:m:s');

            for($i=0; $i<$numOfTweets; $i++) {
                $tweetDate = $tweets[$i]->getCreatedAt()->format('h:m:s');

                var_dump(strtotime($data.'-'.$tweetDate));
            }

            $info = FlashMessage::get('info');
            $logout_message = FlashMessage::get('message');
            $confirm_message = FlashMessage::get('confirm_message');
            $search_errors = FlashMessage::get('search_errors');

            $content = View::render('index', 'default', compact('dateFormat','tweets', 'users', 'numOfTweets', 'numOfUsers', 'info', 'logout_message', 'confirm_message', 'search_errors', 'title'));
            return new Response($content);
        }

        public function explore(Request $request):Response
        {
            $content = View::render('explore', 'default');
            return new Response($content);
        }

        # Funció per utilitzar l'api
        public function api_search(Request $request):Response
        {
            $query = $request->get('query');
            
            if(!is_null($query)){
                $userRepository = Registry::get(UserRepository::class);
                $users = $userRepository->findByUsername($query);

                if(!is_bool($users)) {
                    return new JsonResponse(['resultat'=>'ok']);
                }
                return new JsonResponse(['resultat'=>'ko']);
            }
            return new JsonResponse(['resultat'=>'ko']);
        }
    }