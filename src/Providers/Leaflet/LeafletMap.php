<?php

namespace Maps\Providers\Leaflet;

use Maps\Interfaces\MapInterface;
use Maps\Exceptions\InvalidViewPathException;

class LeafletMap implements MapInterface
{
    protected string $view;
    protected array $config;
    protected array $attributes;

    public function __construct(private readonly string $id)
    {
        $this->view = __DIR__ . '/Views/map.php';
        $this->config = LeafletConfig::defaultOptions();
    }

    public function render(array $config = [], array $attributes = []): string
    {
        if (!file_exists($this->view)) {
            error_log('View file not found: ' . $this->view);
            return '';
        }

        $this->config = array_merge(LeafletConfig::defaultOptions(), $config);
        $this->attributes = array_merge([
            'class' => '',
            'style' => 'width: 100%; height: 500px;'
        ], $attributes);
        $mapId = $this->id;

        ob_start();
        extract($this->config);
        extract($this->attributes);
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