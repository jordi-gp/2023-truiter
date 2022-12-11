<!--Tuits Trobats-->
<h2>Tweets Trobats</h2>
<?php if(!empty($found_tweets)): ?>
    <?php foreach ($found_tweets as $tweet) : ?>
        <?=$tweet->getAuthor()->getUsername();?>
        <p><?=$tweet->getAuthor()->getName();?> (@<?=$tweet->getAuthor()->getUsername();?>) - Creation
            date: <?=$tweet->getCreatedAt()->format("Y-m-d");?></p>
        <blockquote><?=$tweet->getText();?></blockquote>
        <p>Like counter: <?=$tweet->getLikeCount();?></p>
        <?php if(!empty($tweet->getAttachments())): ?>
            <ul>
                <?php foreach($tweet->getAttachments() as $attachment): ?>
                    <li><?=$attachment->getAltText();?></li>
                <?php endforeach; ?>
            </ul>
            <!--<img class="image" style="width: 400px; height: 400px;" src="<?php #$tweet["url"];?>" alt="<?php #$tweet["alt_text"];?>" />-->
        <?php endif ;?>
        <hr/>
    <?php endforeach; ?>
<?php else: ?>
    <h4>No s'han trobat tuits amb els valors indicats</h4>
    <img class="image" src="assets/homer_think.png" alt="not_found_tweet" />
<?php endif; ?>