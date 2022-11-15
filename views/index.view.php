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
            <h1>Welcome to Truiter</h1>
            <p><?=$numOfUsers?> users, <?=$numOfTuits?> tuits</p>
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
            <h2>Users</h2>
            <?php foreach ($users as $user) : ?>
                <p><?= $user["name"]; ?> (@<?= $user["username"]; ?>) - Creation
                    date: <?= $user["created_at"]; ?></p>
            <?php endforeach; ?>
            <h2>Tweets</h2>
            <?php foreach ($tweets as $tweet) : ?>
                <?php $tweet["username"]; ?>
                <p><?= $tweet["name"]; ?> (@<?= $tweet["username"]; ?>) - Creation
                    date: <?= $tweet["created_at"]; ?></p>
                <blockquote><?=$tweet["text"];?></blockquote>
                <p>Like counter: <?= $tweet["like_count"] ?></p>
                <?php //if ($tweet["media_id"] != null) : ?>
                    <h3>Attachments</h3>
                    <img id="imatge" src="../uploads/2ff30d9f970be7f88e141649675892f5.png" alt="imatge_tuit" />
                <?php //endif ;?>
                <hr/>
            <?php endforeach; ?>
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>