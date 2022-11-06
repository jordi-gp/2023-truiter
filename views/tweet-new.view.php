<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Tuiter: una grollera còpia de Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"></head></head>
    <style>
        .error {
            font-weight: bold;
            color: red;
        }

        #imatge {
            width: 300px;
            height: 300px;
        }
    </style>
<body>

<main class="border-top mt-4 border-4 border-primary container">
    <div class="row">
        <div class="col-2 border d-flex flex-column justify-content-between">
                <?php require "partials/sidebar.php" ?>
        </div>
        <div class="col-7 border p-4">
            <h2>Nou truit</h2>
            <form class="mb-4" method="post" action="tweet-new-process.php" enctype="multipart/form-data">
                <textarea class="form-control mb-2" name="tuitValue" placeholder="Què passa, @<?=$user2->getUsername();?>?"></textarea>
                <input type="file" name="tuitFile" class="form-control mb-2" >
                <button class="btn btn-primary" type="submit">Tuit with image</button>
            </form>
            <?php if(!empty($tweet)): ?>
                <!--Mostrar el tweet-->
                <h3>Tweet</h3>
                <p><?= $tweetAuthor->getName()?> (@<?=$tweetAuthor->getUsername()?>) - Creation
                    date: <?=$tweet->getCreatedAt()->format('d-m-Y h:i:s')?></p>
                <blockquote><?= $tweet->getText() ?></blockquote>
                <p>Like counter: <?= $tweet->getLikeCount(); ?></p>
                <!--TODO: Gestionar la putjada del fitxer-->
                <?php if(!empty($_SESSION["imgName"])): ?>
                    <img id="imatge" src="uploads/<?=$_SESSION["imgName"]?>" alt="imatge_personal" />
                <?php endif; ?>
            <?php endif; ?>
            <!--Mostrat d'errors-->
            <?php if(!empty($errors)): ?>
                <?php foreach($errors as $error): ?>
                    <p class="error"><?=$error?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="col-3 border"></div>
    </div>
</main>
</body>
</html>