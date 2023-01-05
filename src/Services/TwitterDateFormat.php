<?php

    namespace App\Services;

    use DateTime;

    class TwitterDateFormat
    {
        public DateTime $currentDateTime;

        public function __construct(DateTime $currentDateTime = new DateTime())
        {
            $this->currentDateTime = $currentDateTime;
        }

        public function format(DateTime $tweetDate):string
        {
            $actTimeStamp = $this->currentDateTime->getTimestamp();
            $tweetTimeStamps = $tweetDate->getTimestamp();

            $diff = $actTimeStamp-$tweetTimeStamps;

            if($diff <0)
                throw new \Exception('No pot haver una data futura');

            # Segons
            if($diff < 60)
                return $diff." s";

            # Minuts
            if($diff < 60*60)
                return floor($diff/60)." min";

            #Hores
            if($diff < 60*60*24)
                return floor($diff/60/60)." h";

            return $tweetDate->format('d-m-Y');
        }
    }