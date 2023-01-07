<?php
/**
 * Class ContinentRect
 *
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

class ContinentRect{

	protected array $rect;

	/**
	 * ContinentRect constructor.
	 *
	 * @param array $continent_rect (NW/SE corners [[nw_x, nw_y],[se_x, se_y]])
	 */
	public function __construct(array $continent_rect){
		$this->rect = $continent_rect;
	}

	/**
	 * returns bounds for L.LatLngBounds() (NE/SW corners)
	 */
	public function getBounds():array{
		return [
			[$this->rect[0][0], $this->rect[1][1]],
			[$this->rect[1][0], $this->rect[0][1]],
		];
	}

	/**
	 * returns the center of the rectangle
	 */
	public function getCenter():array{
		return [
			($this->rect[0][0] + $this->rect[1][0]) / 2,
			($this->rect[0][1] + $this->rect[1][1]) / 2,
		];
	}

	/**
	 * returns a polygon made of the rectangles corners
	 */
	public function getPoly():array{
		return [[
			[$this->rect[0][0], $this->rect[0][1]],
			[$this->rect[1][0], $this->rect[0][1]],
			[$this->rect[1][0], $this->rect[1][1]],
			[$this->rect[0][0], $this->rect[1][1]]
		]];
	}

}
