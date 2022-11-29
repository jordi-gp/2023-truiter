<?php declare(strict_types=1);

    session_start();
    require_once 'autoload.php';

    use App\Registry;
    use App\Services\DB;
    use App\Services\TweetRepository;
    use App\Services\UserRepository;

    # DB credentials info
    $db = "truiter";
    $db_username = "root";
    $db_password = "";
    $db_host = "localhost";


    # Registre dedicata la base de dades
    $db = new DB($db, $db_username, $db_password, $db_host);
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
