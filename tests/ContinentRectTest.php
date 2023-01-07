<?php
/**
 * Class ContinentRectTest
 *
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSONTest;

use chillerlan\GeoJSON\ContinentRect;
use PHPUnit\Framework\TestCase;

class ContinentRectTest extends TestCase{

	protected ContinentRect $rect;

	protected function setUp():void{
		$this->rect = new ContinentRect([[0, 0], [1024, 512]]);
	}

	public function testGetBounds():void{
		$this->assertSame([[0, 512],[1024, 0]], $this->rect->getBounds());
	}

	public function testGetCenter():void{
		$this->assertSame([512, 256], $this->rect->getCenter());
	}

	public function testGetPoly():void{
		$this->assertSame([[[0, 0], [1024, 0], [1024, 512], [0, 512]]], $this->rect->getPoly());
	}

}
