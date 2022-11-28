<?php declare(strict_types=1);

    session_start();
    require_once 'autoload.php';

    use App\Registry;
    use App\Services\DB;
    use App\Services\TweetRepository;
    $db = "truiter";
    $db_username = "root";
    $db_password = "";
    $db_host = "localhost";


    $db = new DB($db, $db_username, $db_password, $db_host);
    Registry::set(Registry::DB, $db);

    $tweetRepository = new TweetRepository();
    Registry::set("TweetRepository", $tweetRepository);
