<?php
return [
    'providers' => [
        'leaflet' => \Maps\Providers\Leaflet\LeafletMap::class,
        'leaflet_polyline' => \Maps\Providers\Leaflet\LeafletPolygonMap::class,
        'google' => \Maps\Providers\GoogleMaps\GoogleMapsMap::class,
    ],
];