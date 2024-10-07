<?php

namespace Maps\Providers\GoogleMaps;

use Maps\Exceptions\InvalidCenterException;
use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidViewPathException;
use Maps\Exceptions\InvalidZoomException;
use Maps\Interfaces\MapInterface;

/**
 * Class GoogleMapsMap
 *
 * This class is responsible for rendering a Google Maps map with support for polygons, custom markers, and overlays.
 */
class GoogleMapsMap implements MapInterface
{
    /**
     * @var array Configuration options for the map
     */
    protected array $config = [];

    /**
     * @var string The ID of the map element
     */
    protected string $id = '';

    /**
     * @var string The path to the view file used for rendering the map
     */
    protected string $view = __DIR__ . '/Views/map.php';

    /**
     * GoogleMapsMap constructor.
     *
     * @param string $id The ID of the map element
     */
    public function __construct(string $id)
    {
        $this->config = GoogleMapConfig::defaultOptions();
        $this->id = $id;
    }

    /**
     * Get the center coordinates of the map.
     *
     * @return array The center coordinates
     */
    public function getCenter(): array
    {
        return $this->config['center'];
    }

    /**
     * Get the zoom level of the map.
     *
     * @return int The zoom level
     */
    public function getZoom(): int
    {
        return $this->config['zoom'];
    }

    /**
     * Get the map type of the map.
     *
     * @return string The map type
     */
    public function getMapType(): string
    {
        return $this->config['mapType'];
    }

    /**
     * Get the ID of the map element.
     *
     * @return string The ID of the map element
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Render the map with the given options.
     *
     * @param  array  $options  Additional options for rendering the map
     *
     * @return string The rendered map HTML
     * @throws InvalidZoomException
     * @throws InvalidCenterException
     * @throws InvalidMaxZoomException
     */
    public function render(array $options = []): string
    {
        $this->config = array_merge($this->config, $options);
        $id = $this->id;
        $center = $this->config['center'];
        $zoom = $this->config['zoom'];
        $mapType = $this->config['mapType'];
        $polygons = $this->config['polygons'] ?? [];
        $markers = $this->config['markers'] ?? [];
        $overlays = $this->config['overlays'] ?? [];
        $apiKey = GoogleMapConfig::apiKey();

        if (count($center) !== 2 || !is_numeric($center[0]) || !is_numeric($center[1])) {
            throw new InvalidCenterException('Invalid center coordinates.');
        }

        if (!is_int($zoom) || $zoom < 0 || $zoom > 21) {
            throw new InvalidZoomException('Invalid zoom level.');
        }

        if (isset($this->config['maxZoom']) && (!is_int($this->config['maxZoom']) || $this->config['maxZoom'] < 0 || $this->config['maxZoom'] > 21)) {
            throw new InvalidMaxZoomException('Invalid maxZoom level.');
        }

        if (!file_exists($this->view)) {
            error_log('View file not found: ' . $this->view);
            return '';
        }

        ob_start();
        $variables = compact('id', 'center', 'zoom', 'mapType', 'polygons', 'markers', 'overlays', 'apiKey');
        extract($variables);
        include $this->view;
        $output = ob_get_clean();

        if ($output === false) {
            error_log('Failed to get buffer content in render method.');
            return '';
        }

        return $output;
    }

    /**
     * Set a custom view file for rendering the map.
     *
     * @param string $viewPath The path to the custom view file
     * @throws InvalidViewPathException If the view file does not exist
     */
    public function setCustomView(string $viewPath): void
    {
        if (!file_exists($viewPath)) {
            throw new InvalidViewPathException();
        }
        $this->view = $viewPath;
    }

    /**
     * Get the map data with the given options.
     *
     * @param array $options Additional options for getting the map data
     * @return array The map data
     */
    public function getData(array $options = []): array
    {
        return array_merge($this->config, $options);
    }
}