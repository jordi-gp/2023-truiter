<?php

    namespace App\Services;

    use DateTime;

    class TwitterDateFormat
    {
        public function format(DateTime $date):string
        {
            $dateAct = new DateTime();
            $actTimeStamp = $dateAct->getTimestamp();
            $tweetTimeStamps = $date->getTimestamp();

            $diff = $actTimeStamp-$tweetTimeStamps;
            $temps = '';

            # Segons
            if($diff < 60) {
                return floor($diff).' secs';
            }

            # Minuts
            if($diff/60 < 60)
                $temps =  floor($diff/60).' minuts';

            # Hores
            if($diff/60/24 < 24)
                $temps = floor($diff/60/24).' hores';

            return $temps;
        }
    }