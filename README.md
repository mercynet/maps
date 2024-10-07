# MapPackage

MapPackage is a PHP library designed to facilitate the integration and rendering of various map providers, such as Leaflet and Google Maps, in web applications. It adheres to SOLID principles, design patterns, and clean code practices, ensuring maintainability and scalability. The package allows developers to either use built-in views for map rendering or customize their own views by providing necessary data. It includes comprehensive tests using PestPHP to ensure reliability and correctness. The package is structured to be easily extendable, allowing the addition of more map providers in the future.

## Features

- **Multiple Map Providers**: Supports various map providers like Leaflet and Google Maps.
- **SOLID Principles**: Ensures maintainable and scalable code.
- **Customizable Views**: Use built-in views or provide custom views.
- **Comprehensive Testing**: Includes tests with PestPHP.
- **Easily Extendable**: Add more map providers as needed.
- **Custom Exceptions**: Provides specific exceptions for better error handling and debugging.

## Installation

To install the package, use Composer:

```bash
composer require mercynet/maps
```
## Usage

### Creating a Map Provider

You can create a map using the specific map class (e.g., LeafletMap):

```php
use Maps\Providers\Leaflet\LeafletMap;

$map = new LeafletMap('mapId');
```

Creating a Map Using Factory
Alternatively, you can create a map using the MapProviderFactory:

```php
use MapPackage\Factories\MapProviderFactory;

$map = MapProviderFactory::create('leaflet');
```

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
```

### Setting a Custom View
To set a custom view for rendering the map, use the setCustomView method:

```php
$map->setCustomView('custom-view.php');
```

### Handling Exceptions
MapPackage provides custom exceptions to handle specific errors. Here are some examples:

- **InvalidCenterException**: Thrown when the center coordinates are invalid.
- **InvalidZoomException**: Thrown when the zoom level is invalid.
- **InvalidTileLayerException**: Thrown when the tile layer URL is invalid.
- **InvalidMaxZoomException**: Thrown when the maximum zoom level is invalid.
- **InvalidViewPathException**: Thrown when the custom view path is invalid.

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
```

## Directory Structure

- `src/`: Contains the source code of the package.
- `tests/`: Contains the tests.
- `composer.json`: Composer configuration file.

## Testing

To run the tests, use PestPHP:

```bash
./vendor/bin/pest
```

## Extending the Package

To add support for a new map provider, implement the `MapProvider` interface:

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
```

Then, register the new provider with the MapProviderFactory using a configuration file or a service provider. Here is an example using a configuration file:

### Configuration File
Create a configuration file config/map_providers.php:

```php
return [
    'providers' => [
        'leaflet' => \MapPackage\Providers\LeafletProvider::class,
        'google' => \MapPackage\Providers\GoogleMapsProvider::class,
        'newmap' => \MapPackage\Providers\NewMapProvider::class,
    ],
];
```

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.
