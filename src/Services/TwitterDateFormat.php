<?php

    namespace App\Services;

    use DateTime;

    class TwitterDateFormat
    {
        public function format(DateTime $date)#:string
        {
            $dateAct = new DateTime();
            $dateNew = new DateTime();
            $time = time();
            var_dump($time);
        }
    }