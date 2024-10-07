<?php

namespace Maps\Providers\GoogleMaps;

use Google\Client;

class GoogleMapConfig
{
    protected static Client $client;
    private static string $apiKey = '';

    public static function initialize(string $apiKey): void
    {
        self::$client = new Client();
        self::$client->setDeveloperKey($apiKey);
        self::$apiKey = $apiKey;
    }

    public static function getDefaultOptions(): array
    {
        return [
            'center' => [0.0, 0.0],
            'zoom' => 8,
            'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'maxZoom' => 18,
            'apiKey' => self::$apiKey, // Add the API key here
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
}