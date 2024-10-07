# Maps Project

This project provides a mapping solution using Google Maps and Leaflet. It includes functionality for rendering maps, adding markers, polygons, and overlays.

## Installation

1. Clone the repository:
```sh
   git clone https://github.com/mercynet/maps-project.git
   cd maps-project
```

2. Install dependencies using Composer:
```sh
   composer install
```

## Configuration

Configure your map providers in `src/config/maps.php`:
```php
return [
    'providers' => [
        'leaflet' => \Maps\Providers\Leaflet\LeafletMap::class,
        'google' => \Maps\Providers\GoogleMaps\GoogleMapsMap::class,
    ],
];
```

## Usage

### Google Maps
To use Google Maps, ensure you have a valid API key. Add the API key to the `GoogleMapConfig` class:

```php
namespace Maps\Providers\GoogleMaps;

class GoogleMapConfig
{
    public static function defaultOptions(): array
    {
        return [
            'center' => [37.7749, -122.4194],
            'zoom' => 12,
            'mapType' => 'roadmap',
            'polygons' => [],
            'markers' => [],
            'overlays' => []
        ];
    }

    public static function getMapType(): string
    {
        return 'roadmap';
    }

    public static function getZoom(): int
    {
        return 12;
    }

    public static function getApiKey(): string
    {
        return 'YOUR_API_KEY';
    }
}
````

Example view file for Google Maps (`src/Providers/GoogleMaps/Views/map.php`):

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Google Map</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey ?? ''; ?>"></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: { lat: <?php echo $center[0] ?? 0; ?>, lng: <?php echo $center[1] ?? 0; ?> },
            zoom: <?php echo $zoom ?? 8; ?>,
            mapTypeId: '<?php echo $mapType ?? 'roadmap'; ?>'
        };
            const map = new google.maps.Map(document.getElementById('<?php echo $id ?? 'map'; ?>'), mapOptions);

            const markers = <?php echo json_encode($markers ?? []); ?>;
            markers.forEach(marker => {
                const markerOptions = {
                    position: { lat: marker.coordinates[0], lng: marker.coordinates[1] },
                    map: map,
                    icon: marker.icon
                };
                const mapMarker = new google.maps.Marker(markerOptions);
                if (marker.popupText) {
                    const infoWindow = new google.maps.InfoWindow({
                        content: marker.popupText
                    });
                    mapMarker.addListener('click', () => {
                        infoWindow.open(map, mapMarker);
                    });
                }
            });

            const overlays = <?php echo json_encode($overlays ?? []); ?>;
            overlays.forEach(overlay => {
                const overlayBounds = new google.maps.LatLngBounds(
                        new google.maps.LatLng(overlay.bounds[0][0], overlay.bounds[0][1]),
                        new google.maps.LatLng(overlay.bounds[1][0], overlay.bounds[1][1])
                );
                new google.maps.GroundOverlay(overlay.url, overlayBounds).setMap(map);
            });
        }
    </script>
</head>
<body onload="initMap()">
<div id="<?php echo $id ?? 'map'; ?>" style="width: 100%; height: 500px;"></div>
</body>
</html>
```

### Leaflet
Example view file for Leaflet (`src/Providers/Leaflet/Views/map.php`):

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: ['<?php echo $center[0] ?? 0; ?>', '<?php echo $center[1] ?? 0; ?>'],
                zoom: <?php echo $zoom ?? 8; ?>
            };
            const map = L.map('<?php echo $id ?? 'map'; ?>').setView(mapOptions.center, mapOptions.zoom);

            L.tileLayer('<?php echo $tileLayer ?? ''; ?>', {
                maxZoom: <?php echo $maxZoom ?? 18; ?>
            }).addTo(map);

            // Adding custom markers
            const markers = <?php echo json_encode($markers ?? []); ?>;
            markers.forEach(marker => {
                L.marker(marker.coordinates, { icon: L.icon(marker.icon) }).addTo(map).bindPopup(marker.popupText);
            });

            // Adding overlays
            const overlays = <?php echo json_encode($overlays ?? []); ?>;
            overlays.forEach(overlay => {
                L.imageOverlay(overlay.url, overlay.bounds).addTo(map);
            });
        }
    </script>
</head>
<body onload="initMap()">
    <div id="<?php echo $id ?? 'map'; ?>" style="width: 100%; height: 500px;"></div>
</body>
</html>
```

### Creating a Map Provider
You can create a map using the specific map class (e.g., `LeafletMap`):

```php
use Maps\Providers\Leaflet\LeafletMap;

$map = new LeafletMap('mapId');
````

### Creating a Map Using Factory
You can create a map using the `MapProviderFactory`:

```php
use MapPackage\Factories\MapProviderFactory;

$map = MapProviderFactory::create('leaflet');
````

### Rendering a Map

To render a map, use the render method of the map class:

```php
$options = [
    'center' => [51.505, -0.09],
    'zoom' => 13,
    'tileLayer' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    'maxZoom' => 18
];

echo $map->render($options);
````

### Setting a Custom View
To set a custom view for rendering the map, use the `setCustomView` method:

```php
$map->setCustomView('path/to/custom-view.php');
````

### Handling Exceptions
MapPackage provides custom exceptions to handle specific errors. Here are some examples:

- **`InvalidCenterException`**: Thrown when the center coordinates are invalid.
- **`InvalidZoomException`**: Thrown when the zoom level is invalid.
- **`InvalidTileLayerException`**: Thrown when the tile layer URL is invalid.
- **`InvalidMaxZoomException`**: Thrown when the maximum zoom level is invalid.
- **`InvalidViewPathException`**: Thrown when the custom view path is invalid.

Example of using exceptions:

```php
use Maps\Exceptions\InvalidCenterException;
use Maps\Exceptions\InvalidZoomException;

try {
    echo $map->render($options);
} catch (InvalidCenterException $e) {
    echo "Error: " . $e->getMessage();
} catch (InvalidZoomException $e) {
    echo "Error: " . $e->getMessage();
}
````

## Directory Structure

- **`src/`**: Contains the source code of the package.
- **`tests/`**: Contains the tests.
- **`composer.json`**: Composer configuration file.

## Testing

To run the tests, use **PestPHP**:

```bash
./vendor/bin/pest
````

## Extending the Package

To add support for a new map provider, implement the `MapInterface` interface:

```php
namespace MapPackage\Providers;

use MapPackage\Contracts\MapProvider;

class NewMapProvider implements MapProvider
{
    public function render(array $options): string
    {
        // Implementation for rendering the map
    }

    public function getData(array $options): array
    {
        // Implementation for providing map data
    }
}
````

Then, register the new provider with the `MapProviderFactory` using a configuration file or a service provider. Here is an example using a configuration file:

### Configuration File
Create a configuration file `config/map_providers.php`:

```php
return [
    'providers' => [
        'leaflet' => \MapPackage\Providers\LeafletProvider::class,
        'google' => \MapPackage\Providers\GoogleMapsProvider::class,
        'newmap' => \MapPackage\Providers\NewMapProvider::class,
    ],
];
````

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.