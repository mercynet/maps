<?php

namespace Maps\Leaflet;

use Maps\Interfaces\MapInterface;

readonly class LeafletMap implements MapInterface
{
    private array $config;

    public function __construct(private string $id, private array $options = [])
    {
        $this->loadConfig();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCenter(): array
    {
        return $this->config['center'];
    }

    public function getZoom(): int
    {
        return $this->config['zoom'];
    }

    public function getTileLayer(): string
    {
        return $this->config['tileLayer'];
    }

    public function getMaxZoom(): int
    {
        return $this->config['maxZoom'];
    }

    public function loadConfig(): void
    {
        $this->config = [
            'center' => $this->options['center'] ?? LeafletConfig::getDefaultOptions()['center'],
            'zoom' => $this->options['zoom'] ?? LeafletConfig::getDefaultOptions()['zoom'],
            'tileLayer' => $this->options['tileLayer'] ?? LeafletConfig::getTileLayer(),
            'maxZoom' => $this->options['maxZoom'] ?? LeafletConfig::getMaxZoom(),
        ];
    }

    public function render(): string
    {
        ob_start();
        include __DIR__ . '/../Views/Leaflet/map.php';
        return ob_get_clean();
    }
}