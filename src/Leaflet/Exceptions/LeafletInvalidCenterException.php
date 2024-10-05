<?php

namespace Maps\Leaflet\Exceptions;

use Exception;

class LeafletInvalidCenterException extends LeafletException
{
    public function __construct($message = "Invalid Leaflet center coordinates.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}