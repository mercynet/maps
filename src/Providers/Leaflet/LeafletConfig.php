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
     *     overlays: array,
     *     centerPoint: float[],
     *     zoomLevel: int,
     *     maxZoomLevel: int,
     *     markerArray: array,
     *     tileHost: string,
     *     attribution: string,
     *     leafletVersion: string,
     *     icon: array
     * }
     */
    public static function defaultOptions(): array
    {
        return [
            'center' => [38.7167, -9.1333], // Lisbon coordinates
            'zoom' => 13,
            'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'maxZoom' => 19,
            'polygons' => [],
            'markers' => [],
            'overlays' => [],
            'centerPoint' => [38.7167, -9.1333], // Lisbon coordinates
            'zoomLevel' => 13,
            'maxZoomLevel' => 19,
            'markerArray' => [],
            'tileHost' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'attribution' => '',
            'leafletVersion' => '1.9.4',
            'icon' => []
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