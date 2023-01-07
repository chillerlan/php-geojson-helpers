<?php
/**
 * Class FeatureTest
 *
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSONTest;

use chillerlan\GeoJSON\{Feature, GeoJSONException};
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase{

	protected Feature $geoJSONFeature;

	protected function setUp():void{
		$this->geoJSONFeature = new Feature;
	}

	public function testToArray():void{

		$id    = 123;
		$type  = 'Point';
		$coord = [10, 10];
		$bbox  = [-10, -10, 10, 10];

		$this->geoJSONFeature = (new Feature($coord, $type, $id))
			->setProperties(['prop1' => 'val1'])
			->setBbox($bbox)
		;

		$arr = $this->geoJSONFeature->toArray();

#		$this->assertSame($id, $arr['id']); // gmaps
		$this->assertSame($id, $arr['properties']['id']); // leaflet
		$this->assertSame('val1', $arr['properties']['prop1']);
		$this->assertSame('Feature', $arr['type']);
		$this->assertSame($bbox, $arr['bbox']);
		$this->assertSame($type, $arr['geometry']['type']);
		$this->assertSame($coord, $arr['geometry']['coordinates']);

		$json = $this->geoJSONFeature->toJSON();

		$this->assertSame('{"type":"Feature","geometry":{"type":"Point","coordinates":[10,10]},"bbox":[-10,-10,10,10],"properties":{"prop1":"val1","id":123}}', $json);
	}

	public function testConstructNoType():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('got coords but no feature type');
		/** @phan-suppress-next-line PhanNoopNew */
		new Feature([0,0]);
	}

	public function testSetGeometryInvalidCoords():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('invalid coords array');

		$this->geoJSONFeature->setGeometry([], '');
	}

	public function testSetGeometryInvalidType():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('invalid geometry type');

		$this->geoJSONFeature->setGeometry([0,0], '');
	}

	public function testSetIDInvalidId():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('invalid id');
		/** @phan-suppress-next-line PhanTypeMismatchArgumentProbablyReal */
		$this->geoJSONFeature->setID(null);
	}

	public function testSetBboxInvalidBox():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('invalid bounding box array');

		$this->geoJSONFeature->setBbox([]);
	}

	public function testToArrayInvalidFeature():void{
		$this->expectException(GeoJSONException::class);
		$this->expectExceptionMessage('invalid feature');

		$this->geoJSONFeature->toArray();
	}

}
