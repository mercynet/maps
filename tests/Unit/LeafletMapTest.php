<?php

use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidZoomException;
use Maps\Providers\Leaflet\Exceptions\LeafletInvalidCenterException;
use Maps\Providers\Leaflet\LeafletConfig;
use Maps\Providers\Leaflet\LeafletMap;

beforeEach(function () {
    $this->map = new LeafletMap('map');
});

it('can load default configurations', function () {
    $config = $this->map->getData();
    expect($config['centerPoint'])->toBe(LeafletConfig::defaultOptions()['centerPoint'])
        ->and($config['zoomLevel'])->toBe(LeafletConfig::defaultOptions()['zoomLevel'])
        ->and($config['tileHost'])->toBe(LeafletConfig::defaultOptions()['tileHost'])
        ->and($config['maxZoomLevel'])->toBe(LeafletConfig::defaultOptions()['maxZoomLevel']);
});

it('can render the map with default configurations', function () {
    $html = $this->map->render();
    expect($html)->toContain('<div id="map" style="width: 100%; height: 500px;"></div>')
        ->and($html)->toContain('const map = L.map');
});
it('returns the correct data', function () {
    $options = [
        'centerPoint' => [40.7128, -74.0060],
        'zoomLevel' => 10,
        'tileHost' => 'https://{s}.tile.custom.org/{z}/{x}/{y}.png',
        'maxZoomLevel' => 18,
        'markers' => [
            [
                'lat' => 40.7128,
                'long' => -74.0060,
                'icon' => 'https://example.com/icon.png',
                'iconSizeX' => 25,
                'iconSizeY' => 41,
                'info' => 'New York'
            ]
        ],
        'markerArray' => [
            [
                'url' => 'https://example.com/overlay.png',
                'bounds' => [[40.7128, -74.0060], [40.7308, -73.9352]]
            ]
        ]
    ];
    expect($this->map->getData($options))->toBe(array_merge(LeafletConfig::defaultOptions(), $options));
});