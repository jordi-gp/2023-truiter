<?php

namespace App\Helpers\Exceptions;

use Exception;
use Throwable;

class InvalidTypeUploadedFileException extends Exception
{
    public function __construct($message = "El format de l'imatge no es correcte", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}