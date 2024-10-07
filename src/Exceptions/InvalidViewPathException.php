<?php

namespace Maps\Exceptions;

use Exception;

class InvalidViewPathException extends MapException
{
    public function __construct(string $message = "Invalid view path.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}