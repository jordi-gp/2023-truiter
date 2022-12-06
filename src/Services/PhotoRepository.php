<?php declare(strict_types=1);

    namespace App\Services;

    use App\Photo;
    use App\Registry;

    class PhotoRepository
    {
        private DB $db;

        public function __construct()
        {
            $this->db = Registry::get(DB::class);
        }

        public function save(Photo $media)
        {
            $data["alt_text"] = $media->getAltText();
            $data["width"] = $media->getWidth();
            $data["height"] = $media->getHeight();
            $data["url"] = $media->getUrl();
            $data["tweet_id"] = $media->getTweet()->getId();

            $sql = "INSERT INTO media (alt_text, width, height, tweet_id, url) VALUES (:alt_text, :width, :height, :tweet_id, :url)";
            $this->db->run($sql, $data);
        }

        public function selectMedia(int $userId):array
        {
            $stmt = $this->db->run("SELECT * FROM tweet t INNER JOIN media m ON t.id=m.tuit_id WHERE user_id=:user_id",
                                ["user_id"=>$userId]);

            $media = [];
            while ($foundMedia = $stmt->fetch())
            {
                $media[] = new Photo($foundMedia["url"], $foundMedia["width"], $foundMedia["height"], $foundMedia["alt_text"]);
            }
            return $media;
        }

        public function deleteMedia(int $tweetId)
        {
            $stmt = $this->db->run("DELETE FROM media WHERE tweet_id=:tweet_id", ["tweet_id"=>$tweetId]);
        }
    }