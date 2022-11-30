<?php
    namespace App\Helpers\Exceptions;

    use Exception;
    use Throwable;

    class InvalidArgumentException extends Exception
    {
        public function __construct($message = "El tamany de caracters es incorrecte", $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }