<?php
/**
 * Class FeatureTest
 *
 * @filesource   FeatureTest.php
 * @created      25.06.2018
 * @package      chillerlan\GeoJSONTest
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSONTest;

use chillerlan\GeoJSON\Feature;
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase{

	/**
	 * @var \chillerlan\GeoJSON\Feature
	 */
	protected $geoJSONFeature;

	protected function setUp(){
		$this->geoJSONFeature = new Feature;
	}

	public function testToArray(){

		$id    = 123;
		$type  = 'Point';
		$coord = [10, 10];
		$bbox  = [-10, -10, 10, 10];

		$this->geoJSONFeature = (new Feature($coord, $type, $id))
			->setProperties(['prop1' => 'val1'])
			->setBbox($bbox)
		;

		$arr = $this->geoJSONFeature->toArray();

#		$this->assertSame($id, $arr['id']);
		$this->assertSame($id, $arr['properties']['id']);
		$this->assertSame('val1', $arr['properties']['prop1']);
		$this->assertSame('Feature', $arr['type']);
		$this->assertSame($bbox, $arr['bbox']);
		$this->assertSame($type, $arr['geometry']['type']);
		$this->assertSame($coord, $arr['geometry']['coordinates']);

		$json = $this->geoJSONFeature->toJSON();

		$this->assertSame('{"type":"Feature","geometry":{"type":"Point","coordinates":[10,10]},"bbox":[-10,-10,10,10],"properties":{"prop1":"val1","id":123}}', $json);
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage got coords but no feature type
	 */
	public function testConstructNoType(){
		new Feature([0,0]);
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage invalid coords array
	 */
	public function testSetGeometryInvalidCoords(){
		$this->geoJSONFeature->setGeometry([], '');
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage invalid geometry type
	 */
	public function testSetGeometryInvalidType(){
		$this->geoJSONFeature->setGeometry([0,0], '');
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage invalid id
	 */
	public function testSetIDInvalidId(){
		$this->geoJSONFeature->setID(null);
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage invalid bounding box array
	 */
	public function testSetBboxInvalidBox(){
		$this->geoJSONFeature->setBbox([]);
	}

	/**
	 * @expectedException \chillerlan\GeoJSON\GeoJSONException
	 * @expectedExceptionMessage invalid feature
	 */
	public function testToArrayInvalidFeature(){
		$this->geoJSONFeature->toArray();
	}

}
