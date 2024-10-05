<?php

namespace Maps\Exceptions;

use Exception;

class InvalidMaxZoomException extends MapException
{
    public function __construct($message = "Invalid max zoom level.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}