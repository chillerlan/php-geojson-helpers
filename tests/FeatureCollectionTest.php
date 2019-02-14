<?php
/**
 * Class FeatureCollectionTest
 *
 * @filesource   FeatureCollectionTest.php
 * @created      25.06.2018
 * @package      chillerlan\GeoJSONTest
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSONTest;

use chillerlan\GeoJSON\{Feature, FeatureCollection};
use PHPUnit\Framework\TestCase;

class FeatureCollectionTest extends TestCase{

	/**
	 * @var \chillerlan\GeoJSON\FeatureCollection
	 */
	protected $geoJSONFeatureCollection;

	protected function setUp(){
		$f1 = new Feature([1,1], 'Point', 1);

		$this->geoJSONFeatureCollection = new FeatureCollection([$f1]);
	}

	public function testToArray(){
		$f2    = new Feature([2,2], 'Point', 2);
		$bbox  = [-10, -10, 10, 10];

		$this->geoJSONFeatureCollection->addFeature($f2)->setBbox($bbox);

		$arr = $this->geoJSONFeatureCollection->toArray();

		$this->assertSame('FeatureCollection', $arr['type']);
		$this->assertSame($bbox, $arr['bbox']);
		$this->assertSame(1, $arr['features'][0]['properties']['id']);
		$this->assertSame(2, $arr['features'][1]['properties']['id']);

		$json = $this->geoJSONFeatureCollection->toJSON();

		$this->assertSame('{"type":"FeatureCollection","bbox":[-10,-10,10,10],"features":[{"type":"Feature","geometry":{"type":"Point","coordinates":[1,1]},"properties":{"id":1}},{"type":"Feature","geometry":{"type":"Point","coordinates":[2,2]},"properties":{"id":2}}]}', $json);
	}

	public function testClearFeatures(){
		$this->geoJSONFeatureCollection->clearFeatures();

		$this->assertSame('{"type":"FeatureCollection","features":[]}', $this->geoJSONFeatureCollection->toJSON());
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage invalid bounding box array
	 */
	public function testSetBboxInvalidBox(){
		$this->geoJSONFeatureCollection->setBbox([]);
	}

}
