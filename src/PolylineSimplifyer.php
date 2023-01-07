<?php
/**
 * Class PolylineSimplifyer
 *
 * @link https://github.com/mourner/simplify-js
 *
 * @created      04.10.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

use function array_fill, array_keys, array_pop, array_push, array_values, count, is_array;

class PolylineSimplifyer{

	protected array $coords;

	/**
	 * PolylineSimplifyer constructor.
	 */
	public function __construct(array $polylineCoords){
		$this->coords = $polylineCoords;
	}

	/**
	 * @throws \chillerlan\GeoJSON\GeoJSONException
	 */
	public function simplify(float $tolerance = 1, bool $highestQuality = false):array{
		$coords = array_values($this->coords ?? []);

		if(count($coords) < 2){
			throw new GeoJSONException('not enough points');
		}

		foreach($this->coords as $coord){
			if(!is_array($coord) || count($coord) < 2){
				throw new GeoJSONException('invalid coords found');
			}
		}

		$sqTolerance = $tolerance * $tolerance;
		$points      = $highestQuality ? $coords : $this->simplifyRadialDist($coords, $sqTolerance);

		return $this->simplifyDouglasPeucker($points, $sqTolerance);
	}

	/**
	 * basic distance-based simplification
	 */
	protected function simplifyRadialDist(array $points, float $sqTolerance):array{
		$prevPoint = $points[0];
		$newPoints = [$prevPoint];
		$point     = null;
		$len       = count($points);

		for($i = 1; $i < $len; $i++){
			$point = $points[$i];

			if($this->getSqDist(array_values($point), array_values($prevPoint)) > $sqTolerance){
				$newPoints[] = $point;
				$prevPoint   = $point;
			}
		}

		if($prevPoint !== $point){
			$newPoints[] = $point;
		}

		return $newPoints;
	}

	/**
	 * square distance between 2 points
	 */
	protected function getSqDist(array $p1, array $p2):float{
		$dx = $p1[0] - $p2[0];
		$dy = $p1[1] - $p2[1];

		return $dx * $dx + $dy * $dy;
	}

	/**
	 * simplification using optimized Douglas-Peucker algorithm with recursion elimination
	 */
	protected function simplifyDouglasPeucker(array $points, float $sqTolerance):array{
		$len       = count($points);
		$markers   = array_fill(0, $len - 1, null);
		$first     = 0;
		$last      = $len - 1;
		$stack     = [];
		$newPoints = [];
		$index     = 0;

		$markers[$first] = $markers[$last] = 1;

		while($last){

			$maxSqDist = 0;

			for($i = $first + 1; $i < $last; $i++){
				$sqDist = $this->getSqSegDist(
					array_values($points[$i]),
					array_values($points[$first]),
					array_values($points[$last])
				);

				if($sqDist > $maxSqDist){
					$index     = $i;
					$maxSqDist = $sqDist;
				}
			}

			if($maxSqDist > $sqTolerance){
				$markers[$index] = 1;
				array_push($stack, $first, $index, $index, $last);
			}

			$last  = array_pop($stack);
			$first = array_pop($stack);
		}

		foreach($points as $i => $point){
			if($markers[$i]){
				$newPoints[] = $point;
			}
		}

		return $newPoints;
	}

	/**
	 * square distance from a point to a segment
	 */
	protected function getSqSegDist(array $p, array $p1, array $p2):float{
		$x  = $p1[0];
		$y  = $p1[1];
		$dx = $p2[0] - $x;
		$dy = $p2[1] - $y;

		if((int)$dx !== 0 || (int)$dy !== 0){

			$t = (($p[0] - $x) * $dx + ($p[1] - $y) * $dy) / ($dx * $dx + $dy * $dy);

			if($t > 1){
				$x = $p2[0];
				$y = $p2[1];

			}
			elseif($t > 0){
				$x += $dx * $t;
				$y += $dy * $t;
			}
		}

		$dx = $p[0] - $x;
		$dy = $p[1] - $y;

		return $dx * $dx + $dy * $dy;
	}

}
