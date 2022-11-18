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
        #imatge {
            width: 300px;
            height: 300px;
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
                <?php //foreach ($tweets as $tweet) : ?>
                    <?php //$tweet["username"]; ?>
                    <p><?php // $tweet["name"]; ?> (@<?php // $tweet["username"]; ?>) - Creation
                        date: <?php // $tweet["created_at"]; ?></p>
                    <blockquote><?php //$tweet["text"];?></blockquote>
                    <p>Like counter: <?php // $tweet["like_count"] ?></p>
                    <?php // if ($tweet["url"] != null) : ?>
                        <img id="imatge" src="<?php //$tweet["url"]?>" alt="<?php //$tweet["alt_text"]?>" />
                    <?php //endif ;?>
                    <hr/>
                <?php //endforeach; ?>
            <?php else: ?>
                <h3>No s'han trobat tuits amb els valors indicats</h3>
            <?php endif; ?>
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>