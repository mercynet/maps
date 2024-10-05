<?php

namespace Maps\Exceptions;

use Exception;

class InvalidCenterException extends MapException
{
    public function __construct(string $message = "Invalid center coordinates.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}