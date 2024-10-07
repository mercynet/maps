<?php

namespace Maps\Factories;

use Maps\Interfaces\MapInterface;
use Maps\Leaflet\LeafletMap;

class MapProviderFactory
{
    public static function create(string $type, string $id): MapInterface
    {
        return match ($type) {
            'leaflet' => new LeafletMap($id),
            default => throw new \InvalidArgumentException("Unsupported map provider type: $type"),
        };
    }
}