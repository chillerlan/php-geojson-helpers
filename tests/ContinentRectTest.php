<?php
/**
 * Class ContinentRectTest
 *
 * @filesource   ContinentRectTest.php
 * @created      25.06.2018
 * @package      chillerlan\GeoJSONTest
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSONTest;

use chillerlan\GeoJSON\ContinentRect;
use PHPUnit\Framework\TestCase;

class ContinentRectTest extends TestCase{

	/**
	 * @var \chillerlan\GeoJSON\ContinentRect
	 */
	protected $rect;

	protected function setUp(){
		$this->rect = new ContinentRect([[0, 0], [1024, 512]]);
	}

	public function testGetBounds(){
		$this->assertSame([[0, 512],[1024, 0]], $this->rect->getBounds());
	}

	public function testGetCenter(){
		$this->assertSame([512, 256], $this->rect->getCenter());
	}

	public function testGetPoly(){
		$this->assertSame([[[0, 0], [1024, 0], [1024, 512], [0, 512]]], $this->rect->getPoly());
	}

}
