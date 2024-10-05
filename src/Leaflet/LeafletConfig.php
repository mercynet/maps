<?php

namespace Maps\Leaflet;

class LeafletConfig
{
    /**
     * @return array{
     *     center: float[],
     *     zoom: int,
     *     tileLayer: string,
     *     maxZoom: int
     * }
     */
    public static function getDefaultOptions(): array
    {
        return [
            'center' => [51.505, -0.09],
            'zoom' => 13,
            'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'maxZoom' => 19,
        ];
    }

    public static function getTileLayer(): string
    {
        return 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    }

    public static function getMaxZoom(): int
    {
        return 19;
    }
}