<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
            <?php if(!empty($info)): ?>
                <p>Benvingut @<?=$info->getUsername();?></p>
            <?php endif; ?>
            <?php if(!empty($_SESSION["message"])): ?>
                <p><?=$_SESSION["message"];?></p>
                <?php unset($_SESSION["message"]); ?>
            <?php endif; ?>
            <p><?= $twitter->getNumberOfUsers() ?> users, <?= $twitter->getNumberOfTweets() ?> tweets.</p>
            <h2>Users</h2>
            <?php foreach ($users as $user) : ?>
                <p><?= $user->getName(); ?> (@<?= $user->getUsername() ?>); - Creation
                    date: <?= $user->getCreatedAt()->format('d-m-Y h:i:s'); ?></p>
            <?php endforeach; ?>
            <h2>Tweets</h2>
            <?php foreach ($AllTweets as $tweet) : ?>
                <?php $tweetUser = $tweet->getAuthor(); ?>
                <p><?= $tweetUser->getName(); ?> (@<?= $tweetUser->getUsername(); ?>) - Creation
                    date: <?= $tweetUser->getCreatedAt()->format("d-m-Y h:i:s"); ?></p>
                <blockquote><?=$tweet->getText();?></blockquote>
                <p>Like counter: <?= $tweet->getLikeCount(); ?></p>
                <?php if (count($tweet->getAttachments()) > 0) : ?>
                    <h3>Attachments</h3>
                    <ul>
                        <?php foreach ($tweet->getAttachments() as $attachment) : ?>
                            <li><?php $attachment->getSummary() ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif ;?>
                <hr/>
            <?php endforeach; ?>
        </div>
        <div class="col-4"></div>
    </div>
</main>
</body>
</html>