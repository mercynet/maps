<?php

namespace Maps\Providers;

use Maps\Interfaces\MapInterface;
use Maps\Exceptions\InvalidZoomException;
use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidViewPathException;

class GoogleMapsMap implements MapInterface
{
    protected array $config;
    protected string $id;
    protected string $view = '../Views/GoogleMaps/map.php';

    public function __construct(string $id)
    {
        $this->config = GoogleMapsConfig::getDefaultOptions();
        $this->id = $id;
    }

    public function getCenter(): array
    {
        $center = $this->config['center'];
        if (is_array($center) && count($center) === 2 && is_float($center[0]) && is_float($center[1])) {
            return $center;
        }
        throw new LeafletInvalidCenterException('Center must be an array of two floats.');
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

        ob_start();
        include $this->view;
        $output = ob_get_clean();
        return $output === false ? '' : $output;
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