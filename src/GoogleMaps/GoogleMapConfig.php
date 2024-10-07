<?php

namespace Maps\GoogleMaps;

use Google\Client;
use Google\Service\MapsEngine;

class GoogleMapConfig
{
    protected static Client $client;
    protected static MapsEngine $mapsEngine;

    public static function initialize(string $apiKey): void
    {
        self::$client = new Client();
        self::$client->setDeveloperKey($apiKey);
        self::$mapsEngine = new MapsEngine(self::$client);
    }

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

    public static function getClient(): Client
    {
        return self::$client;
    }

    public static function getMapsEngine(): MapsEngine
    {
        return self::$mapsEngine;
    }
}