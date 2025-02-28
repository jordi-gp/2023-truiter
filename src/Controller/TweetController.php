<?php

    namespace App\Controller;

    use App\Core\View;
    use App\Helpers\Exceptions\NoUploadedFileException;
    use App\Helpers\Exceptions\UploadedFileException;
    use App\Helpers\FlashMessage;
    use App\Helpers\UploadedFileHandler;
    use App\Helpers\Validator;
    use App\Photo;
    use App\Registry;
    use App\Services\PhotoRepository;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;
    use App\Tweet;
    use App\User;
    use DateTime;
    use Exception;
    use InvalidArgumentException;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    const MAX_SIZE = 1024 * 1024 * 3;
    const UPLOAD_PATH = __DIR__ . "/../../public/uploads";

    class TweetController
    {
        public function tweet_new(Request $request):Response
        {
            if(!isset($_SESSION["logged"])) {
                return new RedirectResponse('/');
            } else {
                $title = "Afig un Tweet";

                # Errors del formulari
                $errors = FlashMessage::get('new_tweet_errors');

                # Informació de l'usuari
                $info = $_SESSION["user"];

                $content = View::render('tweet-new', 'default', compact('errors', 'info', 'title'));
                $response = new Response($content);
                $response->setStatusCode(Response::HTTP_OK);
                return $response;
            }
        }

        public function tweet_new_process(Request $request):Response
        {
            $errors = [];
            $tweet = [
                "tuitValue" => "",
                "tuitFile" => []
            ];

            $imgDir = "uploads";

            $validFormat[] = "image/jpg";
            $validFormat[] = "image/jpeg";
            $validFormat[] = "image/png";

            $userRepository = Registry::get(UserRepository::class);
            $tweetRepository = Registry::get(TweetRepository::class);
            $photoRepository = Registry::get(PhotoRepository::class);
            $validator = Registry::get(Validator::class);

            # Validació del tuit
            $tuitValue = $request->get('tuitValue');
            try {
                $validator->lengthBetween($tuitValue, 2, 250);
                $tweet["tuitValue"] = filter_var($tuitValue, FILTER_SANITIZE_SPECIAL_CHARS);
            } catch (InvalidArgumentException $err) {
                $errors[] = $err->getMessage();
            }

            if(!empty($_FILES)) {
                try {
                    $handle_image = new UploadedFileHandler($_FILES["tuitFile"], $validFormat, MAX_SIZE);
                    $newFilename = $handle_image->handle(UPLOAD_PATH);
                } catch (NoUploadedFileException $e) {
                } catch (UploadedFileException $e){
                    $errors[] = $e->getMessage();
                } catch (Exception $exception) {
                    $errors[] = $exception->getMessage();
                }
            }

            # Gestió a l'hora d'enviar el formulari
            if(!empty($errors)) {
                FlashMessage::set('new_tweet_errors', $errors);
                FlashMessage::set('infoTweet', $tweet);

                unset($_SESSION["newTweet"]);

                return new RedirectResponse('/tweet/new');
            } else {
                # Afegiment d'un nou tweet
                $user_info = $_SESSION["user"];
                $tweetAuthor = new User($user_info["name"], $user_info["username"]);
                $tweetAuthor->setId((int) $user_info["id"]);

                $newTweet = new Tweet($tweet["tuitValue"], $tweetAuthor);
                $newTweet->setCreatedAt(new DateTime());
                $newTweet->setLikeCount(0);

                $tweetRepository->save($newTweet);

                if (!empty($newFilename)) {
                    try {
                        list($width, $height) = getimagesize(UPLOAD_PATH . "/" . $newFilename);
                        $photo = new Photo($newFilename, $width, $height, $newFilename);
                        $photo->setUrl($newFilename);
                        $photo->setTweet($newTweet);
                        $photo->setAltText('Tuit image');
                        $newTweet->addAttachment($photo);
                        $photoRepository->save($photo);
                    } catch (Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                }

                unset($_SESSION["errors"]);
                return new RedirectResponse('/');
            }
        }

        public function find_tweets(Request $request):Response
        {
            $title = "Tuits Trobats";
            # Requeriment dels serveis necessàris
            try {
                $tweetRepository = Registry::get(TweetRepository::class);
            } catch (Exception $err) {
                die($err->getLine()." ".$err->getMessage());
            }

            $query_search = $request->get('query', '');
            $search_errors = [];

            try {
                Validator::lengthBetween($query_search, 2, 100);
            } catch (InvalidArgumentException $err) {
                $search_errors[] = $err->getMessage();
            }

            if(empty($search_errors)) {
                $found_tweets = $tweetRepository->findTweetBy($query_search);

                unset($_SESSION["search_errors"]);

                $content = View::render('found-tweets', 'default', compact('found_tweets', 'title'));

                $response = new Response($content);
                $response->setStatusCode(Response::HTTP_OK);

                return new Response($content);
            } else {
                FlashMessage::set('search_errors', $search_errors);
                return new RedirectResponse('/');
            }
        }
    }