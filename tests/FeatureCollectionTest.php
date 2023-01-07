<?php
/**
 * Class FeatureCollectionTest
 *
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSONTest;

use chillerlan\GeoJSON\{Feature, FeatureCollection, GeoJSONException};
use PHPUnit\Framework\TestCase;
use function json_encode;

class FeatureCollectionTest extends TestCase{

	protected FeatureCollection $geoJSONFeatureCollection;

	protected function setUp():void{
		$f1 = new Feature([1,1], 'Point', 1);

		$this->geoJSONFeatureCollection = new FeatureCollection([$f1]);
	}

	public function testToArray():void{
		$f2    = new Feature([2,2], 'Point', 2);
		$bbox  = [-10, -10, 10, 10];

		$this->geoJSONFeatureCollection->addFeature($f2)->setBbox($bbox);

		$arr = $this->geoJSONFeatureCollection->toArray();

		$this->assertSame('FeatureCollection', $arr['type']);
		$this->assertSame($bbox, $arr['bbox']);
		$this->assertSame(1, $arr['features'][0]['properties']['id']);
		$this->assertSame(2, $arr['features'][1]['properties']['id']);

		$expected = '{"type":"FeatureCollection","bbox":[-10,-10,10,10],"features":['
			.'{"type":"Feature","geometry":{"type":"Point","coordinates":[1,1]},"properties":{"id":1}},'
			.'{"type":"Feature","geometry":{"type":"Point","coordinates":[2,2]},"properties":{"id":2}}]}';

		// legacy toJSON method
		$this->assertSame($expected, $this->geoJSONFeatureCollection->toJSON());
		// JsonSerializable
		$this->assertSame($expected, json_encode($this->geoJSONFeatureCollection));
	}

	public function testClearFeatures():void{
		$this->geoJSONFeatureCollection->clearFeatures();

		$this->assertSame('{"type":"FeatureCollection","features":[]}', $this->geoJSONFeatureCollection->toJSON());
	}

	public function testSetBboxInvalidBox():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('invalid bounding box array');

		$this->geoJSONFeatureCollection->setBbox([]);
	}

}
