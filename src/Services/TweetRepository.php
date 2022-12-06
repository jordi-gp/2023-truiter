<?php declare(strict_types=1);

    namespace App\Services;

    use App\Photo;
    use App\Registry;
    use App\Tweet;
    use App\User;
    use DateTime;

    class TweetRepository
    {
        private DB $db;

        public function __construct()
        {
            $this->db = Registry::get(Registry::DB);
        }

        # Funció per obtindre tots els tuits
        public function findAll():array
        {
            $tweets = [];

            $stmt = $this->db->run("SELECT t.*, u.username, u.name FROM tweet t 
                                        INNER JOIN user u ON t.user_id = u.id 
                                        ORDER BY t.created_at DESC");

            # Obtenció dels tweets
            while ($tweet = $stmt->fetch())
            {
                $stmtUser = $this->db->run("SELECT * FROM user WHERE id=:id", ["id"=>$tweet["user_id"]]);

                $user = $stmtUser->fetch();
                $userObj = new User($user["name"], $user["username"]);

                $tweetObj = new Tweet($tweet["text"], $userObj);
                $tweetObj->setCreatedAt(DateTime::createFromFormat("Y-m-d h:i:s", $tweet["created_at"]));
                $tweetObj->setLikeCount($tweet["like_count"]);

                $stmtMedia = $this->db->run("SELECT * FROM media WHERE tweet_id = :tweet_id",
                    ["tweet_id" => $tweet["id"]]);

                # Obtenció de les imatges dels tweets
                while ($media = $stmtMedia->fetch()) {
                    $mediaObj = new Photo($media["alt_text"], $media["width"],
                        $media["height"], $media["alt_text"]);
                    $tweetObj->addAttachment($mediaObj);
                }
                $tweets[] = $tweetObj;
            }
            return $tweets;
        }

        # Funció per inserir un nou tweet
        public function save(Tweet $tweet)
        {
            $text = $tweet->getText();
            $created_at = $tweet->getCreatedAt()->format("Y-m-d h:i:s");
            $like_count = $tweet->getLikeCount();
            $user_id = $tweet->getAuthor()->getId();

            $stmt = $this->db->run("INSERT INTO tweet(text, created_at, like_count, user_id) 
                    VALUES(:text, :created_at, :like_count, :user_id)",
                    ["text"=>$text, "created_at"=>$created_at, "like_count"=>$like_count, "user_id"=>$user_id]);
        }

        # Funció per borrar els tweets d'un usuari
        public function deleteTweetsFromUser(int $userId)
        {
            $stmt = $this->db->run("DELETE FROM tweet WHERE user_id=:user_id", ["user_id"=>$userId]);
        }

        # Funció per buscar un tuit per contingut
        public function findTweetBy(string $text):array
        {
            $stmt = $this->db->run("SELECT * FROM tweet t INNER JOIN user u ON t.user_id = u.id
                                     LEFT JOIN media m ON t.id = m.tweet_id
                                     WHERE t.text LIKE :text ORDER BY t.created_at DESC",
                                     ["text"=>"%$text%"]);

            $tweetsByText = [];

            while ($foundTweets = $stmt->fetch())
            {
                $userTweet = new User($foundTweets["name"], $foundTweets["username"]);
                $tweets = new Tweet($foundTweets["text"], $userTweet);
                $tweetsByText[] = $tweets;
            }

            return $tweetsByText;
        }
    }
