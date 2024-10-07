<?php

namespace Maps\Providers\GoogleMaps;

/**
 * Class GoogleMapConfig
 *
 * This class provides default configuration options for Google Maps.
 */
class GoogleMapConfig
{
    /**
     * Get the default configuration options for the Google map.
     *
     * @return array{
     *     center: float[],
     *     zoom: int,
     *     mapType: string,
     *     polygons: array,
     *     markers: array,
     *     overlays: array
     * }
     */
    public static function defaultOptions(): array
    {
        return [
            'center' => [37.7749, -122.4194],
            'zoom' => 12,
            'mapType' => 'roadmap',
            'polygons' => [],
            'markers' => [],
            'overlays' => []
        ];
    }

    /**
     * Get the default map type for the Google map.
     *
     * @return string The default map type
     */
    public static function getMapType(): string
    {
        return 'roadmap';
    }

    /**
     * Get the default zoom level for the Google map.
     *
     * @return int The default zoom level
     */
    public static function getZoom(): int
    {
        return 12;
    }

    public static function apiKey(): string
    {
        return 'YOUR_API_KEY';
    }
}