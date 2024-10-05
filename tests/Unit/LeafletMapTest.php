<?php

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