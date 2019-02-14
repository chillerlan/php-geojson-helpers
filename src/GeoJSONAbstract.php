<?php
/**
 * Class GeoJSONAbstract
 *
 * @filesource   GeoJSONAbstract.php
 * @created      14.02.2019
 * @package      chillerlan\GeoJSON
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

abstract class GeoJSONAbstract{

	/**
	 * @var array
	 */
	protected $bbox;

	/**
	 * @param array $bbox
	 *
	 * @return \chillerlan\GeoJSON\GeoJSONAbstract
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
	 * @return array
	 */
	abstract public function toArray():array;

	/**
	 * @param int|null $options
	 *
	 * @return string
	 */
	public function toJSON(int $options = null):string{
		return json_encode($this->toArray(), $options ?? 0);
	}

}
