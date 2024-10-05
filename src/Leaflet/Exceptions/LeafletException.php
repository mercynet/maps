<?php

namespace Maps\Leaflet\Exceptions;

use Exception;
use Maps\Exceptions\MapException;

class LeafletException extends MapException
{
    public function __construct(string $message = "An error occurred with the Leaflet map.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}