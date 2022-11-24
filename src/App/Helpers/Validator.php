<?php
    namespace App\Helpers;

    use App\Helpers\Exceptions\InvalidArgumentException;

    class Validator
    {
        /**
         * @throws InvalidArgumentException
         */
        public static function lengthBetween(string $value, int $min, int $max, string $message):bool
        {
            if(strlen($value) < $min) {
                throw new InvalidArgumentException("El camp no pot contindre ménys de ".$min." caracters");
            } else if(strlen($value) > $max) {
                throw new InvalidArgumentException("El camp no pot contindre més de ".$max." caracters");
            }

            return true;
        }
    }