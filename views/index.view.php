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
        <div class="offset-2 col-6 border-start border-end border-1 p-4">
            <h1>Welcome to Truiter</h1>
            <p><?=$numOfUsers?> users, <?=$numOfTuits?> tuits</p>
            <!--Buscador de Tweets-->
            <div class="mt-2 mb-2">
                <h2>Buscador de Tweets</h2>
                <form class="d-flex" method="post" action="find-tweet.php">
                    <input class="form-control me-2" name="tuit_search" type="search" placeholder="Buscar Tweet..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </form>
                <?php if(!empty($search_errors)): ?>
                    <?php foreach($search_errors as $search_err): ?>
                        <p class="error mt-2"><?=$search_err?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!--Missatge de benvinguda-->
            <?php if(!empty($info)): ?>
                <p>Benvingut @<?= $info["username"]?></p>
            <?php endif; ?>
            <!--Missatge de tancament de sessió-->
            <div>
                <?php if(!empty($_SESSION["message"])): ?>
                    <p><?= $_SESSION["message"] ?></p>
                    <?php unset($_SESSION["message"]);?>
                <?php endif; ?>
            </div>
            <!--Usuaris-->
            <h2>Users</h2>
            <?php foreach ($users as $user) : ?>
                <p><?= $user["name"]; ?> (@<?= $user["username"]; ?>) - Creation
                    date: <?= $user["created_at"]; ?></p>
            <?php endforeach; ?>
            <!--Tuits-->
            <h2>Tweets</h2>
            <?php foreach ($tweets as $tweet) : ?>
                <?php $tweet["username"]; ?>
                <p><?= $tweet["name"]; ?> (@<?= $tweet["username"]; ?>) - Creation
                    date: <?= $tweet["created_at"]; ?></p>
                <blockquote><?=$tweet["text"];?></blockquote>
                <p>Like counter: <?= $tweet["like_count"] ?></p>
                <?php if ($tweet["url"] != null) : ?>
                    <img id="imatge" src="<?=$tweet["url"]?>" alt="<?=$tweet["alt_text"]?>" />
                <?php endif ;?>
                <hr/>
            <?php endforeach; ?>
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>