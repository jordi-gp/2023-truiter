<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" href="../assets/corriol.png" />
    <style>
        #imatge {
            width: 300px;
            height: 300px;
        }

        .error {
            font-weight: bold;
            color: red;
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
        <!--Buscador de tweets-->
        <div class="offset-2 col-6 border-start border-end border-1 p-4">
            <h1>Welcome to Truiter</h1>
            <p><?=$numOfUsers?> users, <?=$numOfTweets?> tuits</p>
            <!--Usuaris-->
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Usuaris
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <?php foreach ($users as $user) : ?>
                            <div class="accordion-body">
                                <?= $user->getName(); ?> (@<?= $user->getUsername(); ?>) - Creation date: <?= $user->getCreatedAt()->format("Y-m-d"); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!--Buscador de Tweets-->
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Buscador de Tweets
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form class="d-flex" method="post" action="find-tweet.php">
                                <input class="form-control me-2" name="tuit_search" type="search" placeholder="Buscar Tweet..." aria-label="Search">
                                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!empty($search_errors)): ?>
                <?php foreach($search_errors as $search_err): ?>
                    <p class="error mt-2"><?=$search_err?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <!--Missatge de benvinguda-->
            <?php if(!empty($info)): ?>
                <div class="alert alert-success" role="alert">
                    Benvingut @<?=$info?>
                </div>
            <?php endif; ?>
            <!--Missatge de tancament de sessió-->
            <div>
                <?php if(!empty($logout_message)): ?>
                    <div class="alert alert-warning" role="alert">
                        <?=$logout_message?>
                    </div>
                <?php endif; ?>
            </div>
            <!--Missatges de confirmació-->
            <div>
                <?php if(!empty($confirm_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?=$confirm_message?>
                    </div>
                <?php endif; ?>
            </div>
            <!--Tuits-->
            <h2>Tweets</h2>
            <?php foreach ($tweets as $tweet) : ?>
                <div class="accordion-body">
                    <p><?= $tweet->getAuthor()->getName(); ?> (@<?= $tweet->getAuthor()->getUsername(); ?>) - Creation
                        date: <?= $tweet->getCreatedAt()->format("Y-m-d"); ?></p>
                    <blockquote><?=$tweet->getText();?></blockquote>
                    <p>Like counter: <?= $tweet->getLikeCount(); ?></p>
                    <?php if(count($tweet->getAttachments()) > 0) : ?>
                        <ul>
                            <?php #foreach($tweet->getAttachments() as $attachment): ?>
                                <li>
                                    <?php #$attachment->getAltText();?>
                                </li>
                            <?php #endforeach; ?>
                        </ul>
                        <!--<img id="imatge" src="<?php #$tweet["url"]?>" alt="<?php #$tweet["alt_text"]?>" />-->
                    <?php endif ;?>
                    <hr/>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>