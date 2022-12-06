<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="../assets/corriol.png" />
    <style>
        .image {
            width: 400px;
            height: 400px;
        }
    </style>
    <title>Truiter: una grollera còpia de Twitter</title>
</head>
<body>
<main class="mt-4 container">
    <div class="row">
        <div class="position-fixed col-2 d-flex flex-column justify-content-between h-75">
            <?php require "partials/sidebar.php" ?>
        </div>
        <div class="offset-2 col-6 border-start border-end border-1 p-4">
            <!--Tuits Trobats-->
            <h2>Tweets Trobats</h2>
            <?php if(!empty($found_tweets)): ?>
                <?php foreach ($found_tweets as $tweet) : ?>
                    <?=$tweet->getAuthor()->getUsername();?>
                    <p><?=$tweet->getAuthor()->getName();?> (@<?=$tweet->getAuthor()->getUsername();?>) - Creation
                        date: <?=$tweet->getCreatedAt()->format("Y-m-d");?></p>
                    <blockquote><?=$tweet->getText();?></blockquote>
                    <p>Like counter: <?=$tweet->getLikeCount();?></p>
                    <?php #if ($tweet["url"] != null) : ?>
                        <img class="image" src="<?php #$tweet["url"];?>" alt="<?php #$tweet["alt_text"];?>" />
                    <?php #endif ;?>
                    <hr/>
                <?php endforeach; ?>
            <?php else: ?>
                <h4>No s'han trobat tuits amb els valors indicats</h4>
                <img class="image" src="assets/homer_think.png" alt="not_found_tweet" />
            <?php endif; ?>
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>