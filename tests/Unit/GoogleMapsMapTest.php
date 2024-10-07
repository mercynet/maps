<?php

use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidZoomException;
use Maps\Exceptions\InvalidCenterException;
use Maps\Exceptions\InvalidViewPathException;
use Maps\Providers\GoogleMaps\GoogleMapConfig;
use Maps\Providers\GoogleMaps\GoogleMapsMap;

it('can load default configurations', function () {
    $map = new GoogleMapsMap('map');
    expect($map->getCenter())->toBe(GoogleMapConfig::defaultOptions()['center'])
        ->and($map->getZoom())->toBe(GoogleMapConfig::defaultOptions()['zoom'])
        ->and($map->getMapType())->toBe(GoogleMapConfig::defaultOptions()['mapType']);
});

it('can render the map with default configurations', function () {
    $map = new GoogleMapsMap('map');
    $html = $map->render();
    expect($html)->toContain('<div id="map" style="width: 100%; height: 500px;"></div>')
        ->and($html)->toContain('const map = new google.maps.Map');
});

it('can render the map with custom configurations', function () {
    $map = new GoogleMapsMap('map');
    $options = [
        'center' => [40.7128, -74.0060],
        'zoom' => 10,
        'mapType' => 'satellite',
        'markers' => [
            [
                'coordinates' => [40.7128, -74.0060],
                'icon' => 'https://example.com/icon.png',
                'popupText' => 'New York'
            ]
        ],
        'overlays' => [
            [
                'url' => 'https://example.com/overlay.png',
                'bounds' => [[40.7128, -74.0060], [40.7308, -73.9352]]
            ]
        ]
    ];
    $html = $map->render($options);
    expect($html)->toContain('<div id="map" style="width: 100%; height: 500px;"></div>')
        ->and($html)->toContain('const map = new google.maps.Map');
});

it('returns the correct id', function () {
    $map = new GoogleMapsMap('map');
    expect($map->getId())->toBe('map');
});

it('throws exception for invalid center', function () {
    $map = new GoogleMapsMap('map-id');
    $options = ['center' => ['invalid', 'center']];
    expect(fn() => $map->render($options))->toThrow(InvalidCenterException::class);
});

it('throws exception for invalid zoom', function () {
    $map = new GoogleMapsMap('map-id');
    $options = ['zoom' => 'invalid'];
    expect(fn() => $map->render($options))->toThrow(InvalidZoomException::class);
});

it('throws exception for invalid maxZoom', function () {
    $map = new GoogleMapsMap('map-id');
    $options = ['maxZoom' => 'invalid'];
    expect(fn() => $map->render($options))->toThrow(InvalidMaxZoomException::class);
});

it('throws exception for invalid view path', function () {
    $map = new GoogleMapsMap('map-id');
    expect(fn() => $map->setCustomView('invalid/path'))->toThrow(InvalidViewPathException::class);
});

it('returns the correct data', function () {
    $map = new GoogleMapsMap('map');
    $options = [
        'center' => [40.7128, -74.0060],
        'zoom' => 10,
        'mapType' => 'satellite',
        'markers' => [
            [
                'coordinates' => [40.7128, -74.0060],
                'icon' => 'https://example.com/icon.png',
                'popupText' => 'New York'
            ]
        ],
        'overlays' => [
            [
                'url' => 'https://example.com/overlay.png',
                'bounds' => [[40.7128, -74.0060], [40.7308, -73.9352]]
            ]
        ]
    ];
    expect($map->getData($options))->toBe(array_merge(GoogleMapConfig::defaultOptions(), $options));
});