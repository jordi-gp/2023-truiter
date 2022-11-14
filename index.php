<?php
    require_once 'autoload.php';
    use App\Photo;
    use App\Tweet;
    use App\Twitter;
    use App\User;
    use App\Video;
    session_start();
    if(!empty($_SESSION["user"])) {
        $info = $_SESSION["user"];
        unset($_SESSION["user"]);
    }
    $msg = "";

    $twitter = new Twitter();
    //Connexió a la base de dades
    require_once('dbConnection.php');

    //Obtenció dels usuaris de la bbdd
    try {
        $stmt = $pdo->prepare("SELECT * FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Inserció d'usuaris
        foreach($users as $user) {
            $user = new User($user["name"], $user["username"]);
            $twitter->addUser($user);
        }
    } catch (PDOException $err) {
        echo $err->getMessage();
    }

    //Obtenció de tweets de la bbdd
    try {
        $stmt = $pdo->prepare("SELECT * FROM tweet ORDER BY created_at DESC");
        $stmt->execute();
        $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $err) {
        $err->getMessage();
    }

    $logedUsers = $twitter->getUsers(); //Usuaris afegits desde la base de dades
    /*$tweet1 = new Tweet($tweets[0]["text"], $logedUsers[0]);
    $twitter->addTweet($tweet1);

    $tweet2 = new Tweet($tweets[1]["text"], $logedUsers[0]);
    $twitter->addTweet($tweet2);

    $tweet3 = new Tweet($tweets[2]["text"], $logedUsers[1]);
    $twitter->addTweet($tweet3);*/

    for($i=0; $i<count($tweets); $i++) {
        $numUser = rand(0, 1);
        $tweet = new Tweet($tweets[$i]["text"], $logedUsers[$numUser]);
        $twitter->addTweet($tweet);
    }

    $users = $twitter->getUsers();
    $AllTweets = $twitter->getTweets();
    require 'views/index.view.php';
