<?php
/**
 * Class GeoJSONAbstract
 *
 * @created      14.02.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

use JsonSerializable;
use function count;
use function in_array;
use function json_encode;

abstract class GeoJSONAbstract implements JsonSerializable{

	protected array $bbox;

	/**
	 * @throws \chillerlan\GeoJSON\GeoJSONException
	 */
	public function setBbox(array $bbox):GeoJSONAbstract{

		if(!in_array(count($bbox), [4, 6], true)){
			throw new GeoJSONException('invalid bounding box array');
		}

		$this->bbox = $bbox;

		return $this;
	}

	/**
	 *
	 */
	abstract public function toArray():array;

	/**
	 *
	 */
	public function toJSON(int $options = null):string{
		return json_encode($this->toArray(), $options ?? 0);
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize():array{
		return $this->toArray();
	}

}
