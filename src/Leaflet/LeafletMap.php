<?php

namespace Maps\Leaflet;

use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidZoomException;
use Maps\Leaflet\Exceptions\LeafletInvalidCenterException;

/**
 * The LeafletMap class is responsible for configuring and rendering a Leaflet map.
 * It allows setting various map options such as center coordinates, zoom level, tile layer, and maximum zoom level.
 * The class also provides methods to retrieve these configurations and render the map as an HTML view.
 */
class LeafletMap
{
    /**
     * @var array<string, mixed> Configuration options for the Leaflet map.
     */
    private array $config;

    /**
     * @var string The ID of the HTML element where the map will be rendered.
     */
    private string $id;

    /**
     * Constructor for the LeafletMap class.
     *
     * Initializes the map configuration by merging default options with user-provided options.
     *
     * @param string $id The ID of the HTML element where the map will be rendered.
     * @param array<string, mixed> $options Optional configuration options to override the defaults.
     */
    public function __construct(string $id, array $options = [])
    {
        $this->config = array_merge(LeafletConfig::getDefaultOptions(), $options);
        $this->id = $id;
    }

    /**
     * Get the center coordinates of the map.
     *
     * Retrieves the latitude and longitude of the map center from the configuration.
     *
     * @return float[] An array containing the latitude and longitude of the map center.
     * @throws LeafletInvalidCenterException
     */
    public function getCenter(): array
    {
        $center = $this->config['center'];
        if (is_array($center) && count($center) === 2 && is_float($center[0]) && is_float($center[1])) {
            return $center;
        }
        throw new LeafletInvalidCenterException('Center must be an array of two floats.');
    }

    /**
     * Get the zoom level of the map.
     *
     * Retrieves the zoom level of the map from the configuration.
     *
     * @return int The zoom level of the map.
     * @throws InvalidZoomException
     */
    public function getZoom(): int
    {
        $zoom = $this->config['zoom'];
        if (is_int($zoom)) {
            return $zoom;
        }
        throw new InvalidZoomException('Zoom must be an integer.');
    }

    /**
     * Get the tile layer URL of the map.
     *
     * Retrieves the URL template for the tile layer from the configuration.
     *
     * @return string The URL template for the tile layer.
     */
    public function getTileLayer(): string
    {
        $tileLayer = $this->config['tileLayer'];
        if (is_string($tileLayer)) {
            return $tileLayer;
        }
        throw new \UnexpectedValueException('TileLayer must be a string.');
    }

    /**
     * Get the maximum zoom level of the map.
     *
     * Retrieves the maximum zoom level of the map from the configuration.
     *
     * @return int The maximum zoom level.
     * @throws InvalidMaxZoomException
     */
    public function getMaxZoom(): int
    {
        $maxZoom = $this->config['maxZoom'];
        if (is_int($maxZoom)) {
            return $maxZoom;
        }
        throw new InvalidMaxZoomException('MaxZoom must be an integer.');
    }

    /**
     * Get the ID of the HTML element where the map will be rendered.
     *
     * Retrieves the ID of the HTML element from the configuration.
     *
     * @return string The ID of the HTML element.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Render the map view.
     *
     * Generates the HTML and JavaScript code to render the map using the configuration options.
     * The method uses output buffering to capture the view content and return it as a string.
     *
     * @return string The HTML and JavaScript code to render the map.
     * @throws InvalidMaxZoomException
     * @throws InvalidZoomException
     * @throws LeafletInvalidCenterException
     */
    public function render(): string
    {
        $id = $this->getId();
        $center = $this->getCenter();
        $zoom = $this->getZoom();
        $tileLayer = $this->getTileLayer();
        $maxZoom = $this->getMaxZoom();

        ob_start();
        include __DIR__ . '/../Views/Leaflet/map.php';
        $output = ob_get_clean();
        return $output === false ? '' : $output;
    }
}