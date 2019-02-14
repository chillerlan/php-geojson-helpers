# chillerlan/php-geojson-helpers



[![version][packagist-badge]][packagist]
[![license][license-badge]][license]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]
[![Scrunitizer][scrutinizer-badge]][scrutinizer]
[![Packagist downloads][downloads-badge]][downloads]
[![PayPal donate][donate-badge]][donate]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-geojson-helpers.svg?style=flat-square
[packagist]: https://packagist.org/packages/chillerlan/php-geojson-helpers
[license-badge]: https://img.shields.io/github/license/chillerlan/php-geojson-helpers.svg?style=flat-square
[license]: https://github.com/chillerlan/php-geojson-helpers/blob/master/LICENSE
[travis-badge]: https://img.shields.io/travis/chillerlan/php-geojson-helpers.svg?style=flat-square
[travis]: https://travis-ci.org/chillerlan/php-geojson-helpers
[coverage-badge]: https://img.shields.io/codecov/c/github/chillerlan/php-geojson-helpers.svg?style=flat-square
[coverage]: https://codecov.io/github/chillerlan/php-geojson-helpers
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/chillerlan/php-geojson-helpers.svg?style=flat-square
[scrutinizer]: https://scrutinizer-ci.com/g/chillerlan/php-geojson-helpers
[downloads-badge]: https://img.shields.io/packagist/dt/chillerlan/php-geojson-helpers.svg?style=flat-square
[downloads]: https://packagist.org/packages/chillerlan/php-geojson-helpers/stats
[donate-badge]: https://img.shields.io/badge/donate-paypal-ff33aa.svg?style=flat-square
[donate]: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WLYUNAT9ZTJZ4

# Documentation

## Requirements
- PHP 7.2+

## Installation
**requires [composer](https://getcomposer.org)**

*composer.json* (note: replace `dev-master` with a [version boundary](https://getcomposer.org/doc/articles/versions.md))
```json
{
	"require": {
		"php": "^7.2",
		"chillerlan/php-geojson-helpers": "dev-master"
	}
}
```

### Manual installation
Download the desired version of the package from [master](https://github.com/chillerlan/php-geojson-helpers/archive/master.zip) or
[release](https://github.com/chillerlan/php-geojson-helpers/releases) and extract the contents to your project folder.  After that:
- run `composer install` to install the required dependencies and generate `/vendor/autoload.php`.
- if you use a custom autoloader, point the namespace `chillerlan\GeoJSON` to the folder `src` of the package

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
method | return | description
------ | ------ | -----------
`__construct(array $coords = null, string $type = null, $id = null)` | - | coords: `[x, y]`
`setGeometry(array $coords, string $type)` | `Feature` |  coords: `[x, y]`, type is one of `Feature::types`
`setProperties(array $properties)` | `Feature` |
`setID($id)` | `Feature` |

###  `FeatureCollection` methods
method | return | description
------ | ------ | -----------
`__construct(iterable $features = null)` | - |
`addFeature(Feature $feature)` | `FeatureCollection` |
`addFeatures(iterable $features)` | `FeatureCollection` |
`clearFeatures()` | `FeatureCollection` |

### common methods to `Feature` and `FeatureCollection`

method | return | description
------ | ------ | -----------
`setBbox(array $bbox)` | `Feature`/`FeatureCollection` |
`toArray()` | array |
`toJSON(int $options = null)` | string |

### `ContinentRect`

method | return | description
------ | ------ | -----------
`__construct(array $continent_rect)` | - | NW/SE corners `[[nw_x, nw_y],[se_x, se_y]]`
`getBounds()` | array |
`getCenter()` | array |
`getPoly()` | array |
