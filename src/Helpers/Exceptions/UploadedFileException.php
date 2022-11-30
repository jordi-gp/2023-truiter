<?php

namespace App\Helpers\Exceptions;

use Exception;
use Throwable;

class UploadedFileException extends Exception
{
    public function __construct($message = "Error al moure l'imatge", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}