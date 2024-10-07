<?php

use Maps\Exceptions\InvalidMaxZoomException;
use Maps\Exceptions\InvalidZoomException;
use Maps\Leaflet\Exceptions\LeafletInvalidCenterException;
use Maps\Leaflet\LeafletMap;
use Maps\Leaflet\LeafletConfig;

it('can load default configurations', function () {
    $map = new LeafletMap('map');
    expect($map->getCenter())->toBe(LeafletConfig::getDefaultOptions()['center'])
        ->and($map->getZoom())->toBe(LeafletConfig::getDefaultOptions()['zoom'])
        ->and($map->getTileLayer())->toBe(LeafletConfig::getDefaultOptions()['tileLayer'])
        ->and($map->getMaxZoom())->toBe(LeafletConfig::getDefaultOptions()['maxZoom']);
});

it('can render the map with default configurations', function () {
    $map = new LeafletMap('map');
    $html = $map->render();
    expect($html)->toContain('<div id="map" style="width: 100%; height: 400px;"></div>')
        ->and($html)->toContain('var map = L.map(\'map\')');
});

it('can render the map with custom configurations', function () {
    $map = new LeafletMap('map');
    $options = [
        'center' => [40.7128, -74.0060],
        'zoom' => 10,
        'tileLayer' => 'https://{s}.tile.custom.org/{z}/{x}/{y}.png',
        'maxZoom' => 18,
    ];
    $html = $map->render($options);
    expect($html)->toContain('<div id="map" style="width: 100%; height: 400px;"></div>')
        ->and($html)->toContain('var map = L.map(\'map\')');
});

it('returns the correct id', function () {
    $map = new LeafletMap('map');
    expect($map->getId())->toBe('map');
});

it('throws exception for invalid center', function () {
    $map = new LeafletMap('map-id');
    $options = ['center' => ['invalid', 'center']];
    expect(fn() => $map->render($options))->toThrow(LeafletInvalidCenterException::class);
});

it('throws exception for invalid zoom', function () {
    $map = new LeafletMap('map-id');
    $options = ['zoom' => 'invalid'];
    expect(fn() => $map->render($options))->toThrow(InvalidZoomException::class);
});

it('throws exception for invalid tileLayer', function () {
    $map = new LeafletMap('map-id');
    $options = ['tileLayer' => 12345];
    expect(fn() => $map->render($options))->toThrow(\UnexpectedValueException::class);
});

it('throws exception for invalid maxZoom', function () {
    $map = new LeafletMap('map-id');
    $options = ['maxZoom' => 'invalid'];
    expect(fn() => $map->render($options))->toThrow(InvalidMaxZoomException::class);
});

it('returns the correct data', function () {
    $map = new LeafletMap('map');
    $options = [
        'center' => [40.7128, -74.0060],
        'zoom' => 10,
        'tileLayer' => 'https://{s}.tile.custom.org/{z}/{x}/{y}.png',
        'maxZoom' => 18,
    ];
    expect($map->getData($options))->toBe(array_merge(LeafletConfig::getDefaultOptions(), $options));
});