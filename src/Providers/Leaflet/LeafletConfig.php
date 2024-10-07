<?php

namespace Maps\Providers\Leaflet;

/**
 * Class LeafletConfig
 *
 * This class provides default configuration options for Leaflet maps.
 */
class LeafletConfig
{
    /**
     * Get the default configuration options for the Leaflet map.
     *
     * @return array{
     *     center: float[],
     *     zoom: int,
     *     tileLayer: string,
     *     maxZoom: int,
     *     polygons: array,
     *     markers: array,
     *     overlays: array
     * }
     */
    public static function defaultOptions(): array
    {
        return [
            'center' => [51.505, -0.09],
            'zoom' => 13,
            'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'maxZoom' => 19,
            'polygons' => [], // Support for polygons
            'markers' => [],  // Support for custom markers
            'overlays' => []  // Support for overlays
        ];
    }

    /**
     * Get the tile layer URL for the Leaflet map.
     *
     * @return string The tile layer URL
     */
    public static function getTileLayer(): string
    {
        return 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    }

    /**
     * Get the maximum zoom level for the Leaflet map.
     *
     * @return int The maximum zoom level
     */
    public static function getMaxZoom(): int
    {
        return 19;
    }
}