# chillerlan/php-geojson-helpers



[![PHP Version Support][php-badge]][php]
[![version][packagist-badge]][packagist]
[![license][license-badge]][license]
[![Continuous Integration][gh-action-badge]][gh-action]
[![Coverage][coverage-badge]][coverage]
[![Scrunitizer][scrutinizer-badge]][scrutinizer]
[![Packagist downloads][downloads-badge]][downloads]

[php-badge]: https://img.shields.io/packagist/php-v/chillerlan/php-geojson-helpers?logo=php&color=8892BF
[php]: https://www.php.net/supported-versions.php
[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-geojson-helpers.svg?logo=packagist
[packagist]: https://packagist.org/packages/chillerlan/php-geojson-helpers
[license-badge]: https://img.shields.io/github/license/chillerlan/php-geojson-helpers.svg
[license]: https://github.com/chillerlan/php-geojson-helpers/blob/master/LICENSE
[gh-action-badge]: https://img.shields.io/github/actions/workflow/status/chillerlan/php-geojson-helpers/tests.yml?branch=master&logo=github
[gh-action]: https://github.com/chillerlan/php-geojson-helpers/actions/workflows/tests.yml?query=branch%3Amaster
[coverage-badge]: https://img.shields.io/codecov/c/github/chillerlan/php-geojson-helpers.svg?logo=codecov
[coverage]: https://codecov.io/github/chillerlan/php-geojson-helpers
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/chillerlan/php-geojson-helpers.svg?logo=scrutinizer
[scrutinizer]: https://scrutinizer-ci.com/g/chillerlan/php-geojson-helpers
[downloads-badge]: https://img.shields.io/packagist/dt/chillerlan/php-geojson-helpers.svg?logo=packagist
[downloads]: https://packagist.org/packages/chillerlan/php-geojson-helpers/stats

# Documentation

## Requirements
- PHP 7.4+
  - [`ext-json`](https://www.php.net/manual/book.json.php)

## Installation
**requires [composer](https://getcomposer.org)**

*composer.json* (note: replace `dev-master` with a [version boundary](https://getcomposer.org/doc/articles/versions.md))
```json
{
	"require": {
		"php": "^7.4 || ^8.0",
		"chillerlan/php-geojson-helpers": "dev-master"
	}
}
```

Profit!

## Usage

```php
$featureCollection = (new FeatureCollection)->setBbox([0, 0, 1024, 1024]);

// add a single feature
$feature = new Feature([512, 512], 'Point', 1);
$featureCollection->addFeature($feature);

// add an iterable of features
$featureCollection->addFeatures([$feature, /* ... more features ... */]);

// create the GeoJSON, feed leaflet
$json = $featureCollection->toJSON();

// as of v2.x via JsonSerializable
$json = json_encode($featureCollection);

```

```json
{
    "type":"FeatureCollection",
    "bbox":[0, 0, 1024, 1024],
    "features":[
        {
            "type":"Feature",
            "geometry":{
                "type":"Point",
                "coordinates":[512, 512]
            },
            "properties":{
                "id":1
            }
        }
    ]
}
```

## API

###  `Feature` methods
| method                                                               | return    | description                                       |
|----------------------------------------------------------------------|-----------|---------------------------------------------------|
| `__construct(array $coords = null, string $type = null, $id = null)` | -         | coords: `[x, y]`                                  |
| `setGeometry(array $coords, string $type)`                           | `Feature` | coords: `[x, y]`, type is one of `Feature::types` |
| `setProperties(array $properties)`                                   | `Feature` |                                                   |
| `setID($id)`                                                         | `Feature` |                                                   |

###  `FeatureCollection` methods
| method                                   | return              | description |
|------------------------------------------|---------------------|-------------|
| `__construct(iterable $features = null)` | -                   |             |
| `addFeature(Feature $feature)`           | `FeatureCollection` |             |
| `addFeatures(iterable $features)`        | `FeatureCollection` |             |
| `clearFeatures()`                        | `FeatureCollection` |             |

### common methods to `Feature` and `FeatureCollection`

| method                        | return                        | description             |
|-------------------------------|-------------------------------|-------------------------|
| `setBbox(array $bbox)`        | `Feature`/`FeatureCollection` |                         |
| `toArray()`                   | array                         |                         |
| `toJSON(int $options = null)` | string                        |                         |
| `jsonSerialize()`             | array                         | from `JsonSerializable` |

### `ContinentRect`

| method                               | return | description                                 |
|--------------------------------------|--------|---------------------------------------------|
| `__construct(array $continent_rect)` | -      | NW/SE corners `[[nw_x, nw_y],[se_x, se_y]]` |
| `getBounds()`                        | array  |                                             |
| `getCenter()`                        | array  |                                             |
| `getPoly()`                          | array  |                                             |

### `PolylineSimplifyer`
| method                                                         | return | description                                                   |
|----------------------------------------------------------------|--------|---------------------------------------------------------------|
| `__construct(array $polylineCoords)`                           | -      | an array of polyline coordiantes: `[[x1, y1], [x2, y2], ...]` |
| `simplify(float $tolerance = 1, bool $highestQuality = false)` | array  |                                                               |
