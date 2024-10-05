<?php

namespace Maps\Exceptions;

use Exception;

class InvalidTileLayerException extends MapException
{
    public function __construct(string $message = "Invalid tile layer URL.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}