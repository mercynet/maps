<?php

namespace Maps\Providers\GoogleMaps;

use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidViewPathException;
use Maps\Exceptions\InvalidZoomException;
use Maps\Exceptions\InvalidCenterException;
use Maps\Interfaces\MapInterface;

class GoogleMapsMap implements MapInterface
{
    protected array $config = [];
    protected string $id = '';
    protected string $view = __DIR__ . '/../../Views/GoogleMaps/map.php';

    public function __construct(string $id)
    {
        $this->config = GoogleMapConfig::getDefaultOptions();
        $this->id = $id;
    }

    public function getCenter(): array
    {
        $center = $this->config['center'];
        if (is_array($center) && count($center) === 2 && is_float($center[0]) && is_float($center[1])) {
            return $center;
        }
        throw new InvalidCenterException('Center must be an array of two floats.');
    }

    public function getZoom(): int
    {
        $zoom = $this->config['zoom'];
        if (is_int($zoom)) {
            return $zoom;
        }
        throw new InvalidZoomException('Zoom must be an integer.');
    }

    public function getTileLayer(): string
    {
        $tileLayer = $this->config['tileLayer'];
        if (is_string($tileLayer)) {
            return $tileLayer;
        }
        throw new \UnexpectedValueException('TileLayer must be a string.');
    }

    public function getMaxZoom(): int
    {
        $maxZoom = $this->config['maxZoom'];
        if (is_int($maxZoom)) {
            return $maxZoom;
        }
        throw new InvalidMaxZoomException('MaxZoom must be an integer.');
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function render(array $options = []): string
    {
        $this->config = array_merge($this->config, $options);
        $id = $this->getId();
        $center = $this->getCenter();
        $zoom = $this->getZoom();
        $tileLayer = $this->getTileLayer();
        $maxZoom = $this->getMaxZoom();
        $apiKey = $this->config['apiKey'];

        if (!file_exists($this->view)) {
            error_log('View file not found: ' . $this->view);
            return '';
        }

        ob_start();
        extract(compact('id', 'center', 'zoom', 'tileLayer', 'maxZoom', 'apiKey'));
        include $this->view;
        $output = ob_get_clean();

        if ($output === false) {
            error_log('Failed to get buffer content in render method.');
            return '';
        }

        return $output;
    }

    public function setCustomView(string $viewPath): void
    {
        if (!file_exists($viewPath)) {
            throw new InvalidViewPathException();
        }
        $this->view = $viewPath;
    }

    public function getData(array $options = []): array
    {
        return array_merge($this->config, $options);
    }
}