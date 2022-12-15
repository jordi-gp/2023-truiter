<?php
    namespace App\Helpers;

    use InvalidArgumentException;

    class Validator
    {
        /**
         * @throws InvalidArgumentException
         */
        public static function lengthBetween(string $value, int $min, int $max, string $message=""):bool
        {
            if(strlen($value) < $min) {
                $defaultMessage = "Els camps han de contindre almenys ".$min." caracters";
                $errorMessage = "";
                if(!empty($message)) {
                    $errorMessage = $message;
                } else {
                    $errorMessage = $defaultMessage;
                }

                throw new InvalidArgumentException($errorMessage);
            } else if(strlen($value) >= $max) {
                $defaultMessage = "Els camps no pot contindre més de ".$max." caracters";
                $errorMessage = "";
                if(!empty($message)) {
                    $errorMessage = $message;
                } else {
                    $errorMessage = $defaultMessage;
                }
                throw new InvalidArgumentException($errorMessage);
            }
            return true;
        }
    }