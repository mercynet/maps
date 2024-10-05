<?php

namespace Maps\Exceptions;

use Exception;

class MapException extends Exception
{
    public function __construct($message = "An error occurred with the map.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}