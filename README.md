# Maps

Maps is a PHP library designed to facilitate the integration and rendering of various map providers, such as Leaflet and Google Maps, in web applications. It adheres to SOLID principles, design patterns, and clean code practices, ensuring maintainability and scalability. The package allows developers to either use built-in views for map rendering or customize their own views by providing necessary data. It includes comprehensive tests using PestPHP to ensure reliability and correctness. The package is structured to be easily extendable, allowing the addition of more map providers in the future.

## Features

- **Multiple Map Providers**: Supports Leaflet and Google Maps.
- **SOLID Principles**: Ensures maintainable and scalable code.
- **Customizable Views**: Use built-in views or provide custom views.
- **Comprehensive Testing**: Includes tests with PestPHP.
- **Easily Extendable**: Add more map providers as needed.

## Installation

To install the package, use Composer:

```bash
composer require mercynet/maps
```
## Usage

### Creating a Map Provider

You can create a map provider using the `MapProviderFactory`:

```php
use MapPackage\Factories\MapProviderFactory;

$leafletProvider = MapProviderFactory::create('leaflet');
$googleMapsProvider = MapProviderFactory::create('google');
```

### Rendering a Map

To render a map, use the render method of the provider:

```php
$options = [
    'center' => [51.505, -0.09],
    'zoom' => 13
];

echo $leafletProvider->render($options);
```

### Getting Map Data

To get the data for a custom view, use the getData method:

```php
$data = $googleMapsProvider->getData($options);
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

Then, update the MapProviderFactory to include the new provider:

```php
namespace MapPackage\Factories;

use MapPackage\Contracts\MapProvider;
use MapPackage\Providers\LeafletProvider;
use MapPackage\Providers\GoogleMapsProvider;
use MapPackage\Providers\NewMapProvider;

class MapProviderFactory
{
    public static function create(string $type): MapProvider
    {
        return match ($type) {
            'leaflet' => new LeafletProvider(),
            'google' => new GoogleMapsProvider(),
            'newmap' => new NewMapProvider(),
            default => throw new \InvalidArgumentException("Unsupported map provider type: $type"),
        };
    }
}
```

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.
