<?php

namespace Maps\Leaflet\Exceptions;

use Exception;
use Maps\Exceptions\MapException;

class LeafletException extends MapException
{
    public function __construct($message = "An error occurred with the Leaflet map.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}