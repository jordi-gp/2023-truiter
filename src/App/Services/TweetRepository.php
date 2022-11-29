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
        function addTweet()
        {

        }
    }
