<?php

namespace Maps\Exceptions;

use Exception;

class InvalidZoomException extends MapException
{
    public function __construct($message = "Invalid zoom level.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}