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
        ->and($map->getTileLayer())->toBe(LeafletConfig::getTileLayer())
        ->and($map->getMaxZoom())->toBe(LeafletConfig::getMaxZoom());
});

it('can load custom configurations', function () {
    $options = [
        'center' => [40.7128, -74.0060],
        'zoom' => 10,
        'tileLayer' => 'https://{s}.tile.custom.org/{z}/{x}/{y}.png',
        'maxZoom' => 18,
    ];
    $map = new LeafletMap('map', $options);
    expect($map->getCenter())->toBe($options['center'])
        ->and($map->getZoom())->toBe($options['zoom'])
        ->and($map->getTileLayer())->toBe($options['tileLayer'])
        ->and($map->getMaxZoom())->toBe($options['maxZoom']);
});

it('can render the map', function () {
    $map = new LeafletMap('map');
    $html = $map->render();
    expect($html)->toContain('<div id="map" style="width: 100%; height: 400px;"></div>')
        ->and($html)->toContain('var map = L.map(\'map\')');
});

it('returns the correct id', function () {
    $map = new LeafletMap('map');
    expect($map->getId())->toBe('map');
});

it('loads default values when options are not provided', function () {
    $map = new LeafletMap('map');
    expect($map->getCenter())->toBe(LeafletConfig::getDefaultOptions()['center'])
        ->and($map->getZoom())->toBe(LeafletConfig::getDefaultOptions()['zoom'])
        ->and($map->getTileLayer())->toBe(LeafletConfig::getTileLayer())
        ->and($map->getMaxZoom())->toBe(LeafletConfig::getMaxZoom());
});

it('initializes correctly', function () {
    $map = new LeafletMap('map-id', [
        'center' => [51.505, -0.09],
        'zoom' => 13,
        'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'maxZoom' => 18,
    ]);

    expect($map->getId())->toBe('map-id')
        ->and($map->getCenter())->toBe([51.505, -0.09])
        ->and($map->getZoom())->toBe(13)
        ->and($map->getTileLayer())->toBe('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
        ->and($map->getMaxZoom())->toBe(18);
});

it('renders correctly', closure: function () {
    $map = new LeafletMap('map-id', [
        'center' => [51.505, -0.09],
        'zoom' => 13,
        'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'maxZoom' => 18,
    ]);

    $output = $map->render();
    expect($output)->toContain('<div id="map-id"');
    expect($output)->toContain('L.map(\'map-id\')');
});

it('throws exception for invalid center', function () {
    $map = new LeafletMap('map-id', [
        'center' => ['invalid', 'center'],
    ]);

    expect(fn() => $map->getCenter())->toThrow(LeafletInvalidCenterException::class);
});

it('throws exception for invalid zoom', function () {
    $map = new LeafletMap('map-id', [
        'zoom' => 'invalid',
    ]);

    expect(fn() => $map->getZoom())->toThrow(InvalidZoomException::class);
});

it('throws exception for invalid tileLayer', function () {
    $map = new LeafletMap('map-id', [
        'tileLayer' => 12345,
    ]);

    expect(fn() => $map->getTileLayer())->toThrow(UnexpectedValueException::class);
});

it('throws exception for invalid maxZoom', function () {
    $map = new LeafletMap('map-id', [
        'maxZoom' => 'invalid',
    ]);

    expect(fn() => $map->getMaxZoom())->toThrow(InvalidMaxZoomException::class);
});