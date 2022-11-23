<?php

namespace App\Exceptions;

class NoUploadedFileException extends \Exception
{
    public function __construct($message = "Non uploaded file", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}