<?php declare(strict_types=1);
    session_start();

    require_once 'vendor/autoload.php';

    use App\Helpers\Validator;

    use App\Registry;

    use App\Services\DB;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;

    use Monolog\Level;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    $log = new Logger('App');
    $log->pushHandler(new StreamHandler('var/app.log', Level::Debug));
    try {
        Registry::set('logger', $log);
    } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
        echo $e->getMessage();
    }

    # DB credentials info
    $db_name = "truiter";
    $db_username = "root";
    $db_password = "";
    $db_host = "localhost";

    # Registre dedicata la base de dades
    $db = new DB($db_name, $db_username, $db_password, $db_host);
    try {
        Registry::set(Registry::DB, $db);
    } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
        echo $e->getMessage();
    }

    # Registre dedicat a les funcions dels tweets
    $tweetRepository = new TweetRepository();
    try {
        Registry::set(TweetRepository::class, $tweetRepository);
    } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
        echo $e->getMessage();
    }

    # Registre dedicat a les funcions d'usuari
    $userRepository = new UserRepository();
    try {
        Registry::set(UserRepository::class, $userRepository);
    } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
        echo $e->getMessage();
    }

    $log = new Logger('App');
    try {
        $log->pushHandler(new StreamHandler('var/app.log', Level::Debug));
        Registry::set('logged', $log);
    } catch (\App\Helpers\Exceptions\InvalidArgumentException $e) {
        echo $e->getMessage();
    }

    # Registre per a la classe validator
    $validator = new Validator();
    try {
        Registry::set(Validator::class, $validator);
    } catch (App\Helpers\Exceptions\InvalidArgumentException $e) {
        echo $e->getMessage();
    }
