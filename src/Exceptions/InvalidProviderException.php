<?php

namespace Maps\Exceptions;

use Exception;

class InvalidProviderException extends MapException
{
    public function __construct(string $message = 'Invalid provider', int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}