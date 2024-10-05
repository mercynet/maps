<?php

namespace Maps\Exceptions;

use Exception;

class InvalidTileLayerException extends MapException
{
    public function __construct($message = "Invalid tile layer URL.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}