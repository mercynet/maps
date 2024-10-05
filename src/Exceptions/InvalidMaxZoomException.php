<?php

namespace Maps\Exceptions;

use Exception;

class InvalidMaxZoomException extends MapException
{
    public function __construct(string $message = "Invalid max zoom level.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}