<?php

namespace Maps\Providers\Leaflet;

use Maps\Exceptions\InvalidViewPathException;
use Maps\Interfaces\MapInterface;

/**
 * Class LeafletPolygonMap
 *
 * This class is responsible for rendering a Leaflet map with support for polygons, custom markers, and overlays.
 */
class LeafletPolygonMap implements MapInterface
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
    protected string $view = __DIR__.'/Views/polygon_map.php';

    protected array $attributes;

    /**
     * LeafletPolygonMap constructor.
     *
     * @param string $id The ID of the map element
     */
    public function __construct(string $id)
    {
        $this->config = LeafletConfig::defaultOptions();
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
     * Get the tile layer URL of the map.
     *
     * @return string The tile layer URL
     */
    public function getTileLayer(): string
    {
        return $this->config['tileLayer'];
    }

    /**
     * Get the maximum zoom level of the map.
     *
     * @return int The maximum zoom level
     */
    public function getMaxZoom(): int
    {
        return $this->config['maxZoom'];
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
     * @param array $options Additional options for rendering the map
     * @return string The rendered map HTML
     */
    public function render(array $options = [], array $attributes = []): string
    {
        $this->config = array_merge($this->config, $options);
        $id = $this->getId();
        $center = $this->getCenter();
        $zoom = $this->getZoom();
        $tileLayer = $this->getTileLayer();
        $maxZoom = $this->getMaxZoom();
        $polygons = $this->config['polygons'] ?? [];
        $markers = $this->config['markers'] ?? [];
        $overlays = $this->config['overlays'] ?? [];

        if (!file_exists($this->view)) {
            error_log('View file not found: ' . $this->view);
            return '';
        }
        $this->attributes = array_merge([
            'class' => '',
            'style' => 'width: 100%; height: 500px;'
        ], $attributes);
        $mapId = $this->id;

        ob_start();
        $variables = compact('id', 'center', 'zoom', 'tileLayer', 'maxZoom', 'polygons', 'markers', 'overlays');
        extract($this->config);
        extract($this->attributes);
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