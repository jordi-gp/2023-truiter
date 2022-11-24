<?php

namespace App\Helpers\Exceptions;

use Exception;
use Throwable;

class TooBigUploadedFileException extends Exception
{
    public function __construct($message = "El tamany del fitxer es massa gran", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}