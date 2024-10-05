<?php

namespace Maps\Leaflet\Exceptions;

use Exception;

class LeafletInvalidCenterException extends LeafletException
{
    public function __construct(string $message = "Invalid Leaflet center coordinates.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}