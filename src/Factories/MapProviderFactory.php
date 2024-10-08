<?php

namespace Maps\Factories;

use Maps\Exceptions\InvalidProviderException;
use Maps\Interfaces\MapInterface;

/**
 * Factory class for creating map provider instances.
 *
 * This class is responsible for loading map provider configurations and creating instances
 * of map providers based on the given type. It supports both default and custom configurations.
 */
class MapProviderFactory
{
    /**
     * @var array<string, string> Array of map provider class names indexed by provider type.
     */
    protected static array $providers = [];

    /**
     * Initializes the factory with optional custom configurations for map providers.
     *
     * @param array<string, string> $customConfig Optional custom configuration for map providers.
     */
    public static function initialize(array $customConfig = []): void
    {
        self::loadProviders($customConfig);
    }

    /**
     * Loads the map providers from the default and custom configurations.
     *
     * This method merges the default configuration with any custom configuration provided.
     *
     * @param array $customConfig Optional custom configuration for map providers.
     */
    protected static function loadProviders(array $customConfig = []): void
    {
        $defaultConfig = include __DIR__ . '/../config/maps.php';
        self::$providers = array_merge($defaultConfig['providers'], $customConfig['providers'] ?? []);
    }

    /**
     * Creates a map provider instance based on the given type.
     *
     * @param string $type The type of map provider to create.
     * @param string $id The ID of the map element.
     * @return MapInterface The created map provider instance.
     * @throws InvalidProviderException If the map provider type is unsupported.
     */
    public static function create(string $type, string $id): MapInterface
    {
        if (empty(self::$providers)) {
            self::initialize();
        }

        if (!isset(self::$providers[$type])) {
            throw new InvalidProviderException("Unsupported map provider type: $type");
        }

        $providerClass = self::$providers[$type];
        $providerInstance = new $providerClass($id);

        if (!$providerInstance instanceof MapInterface) {
            throw new InvalidProviderException("The provider class $providerClass does not implement MapInterface.");
        }

        return $providerInstance;
    }
}