<?php
/**
 * Class Feature
 *
 * @link https://tools.ietf.org/html/rfc7946
 *
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

use function in_array;
use function is_int;
use function is_string;

class Feature extends GeoJSONAbstract{

	public const types = [
		'Point',
		'MultiPoint',
		'LineString',
		'MultiLineString',
		'Polygon',
		'MultiPolygon',
		'GeometryCollection',
	];

	protected array  $coords;
	protected string $type;
	protected array  $properties;
	/** @var int|string */
	protected $id;

	/**
	 * Feature constructor.
	 *
	 * @param array|null      $coords
	 * @param string|null     $type
	 * @param int|string|null $id
	 *
	 * @throws \chillerlan\GeoJSON\GeoJSONException
	 */
	public function __construct(array $coords = null, string $type = null, $id = null){

		if($coords !== null){

			if($type === null){
				throw new GeoJSONException('got coords but no feature type');
			}

			$this->setGeometry($coords, $type);
		}

		if($id !== null){
			$this->setID($id);
		}

	}

	/**
	 * @throws \chillerlan\GeoJSON\GeoJSONException
	 */
	public function setGeometry(array $coords, string $type):Feature{

		if(empty($coords)){
			throw new GeoJSONException('invalid coords array');
		}

		if(!in_array($type, $this::types, true)){
			throw new GeoJSONException('invalid geometry type');
		}

		$this->coords = $coords;
		$this->type   = $type;

		return $this;
	}

	/**
	 *
	 */
	public function setProperties(array $properties):Feature{
		$this->properties = $properties;

		return $this;
	}

	/**
	 * @param int|string $id
	 *
	 * @throws \chillerlan\GeoJSON\GeoJSONException
	 */
	public function setID($id):Feature{

		if(!is_string($id) && !is_int($id)){
			throw new GeoJSONException('invalid id');
		}

		$this->id = $id;

		return $this;
	}

	/**
	 * @throws \chillerlan\GeoJSON\GeoJSONException
	 */
	public function toArray():array{
		$arr = ['type' => 'Feature'];

		if(empty($this->coords) || empty($this->type)){
			throw new GeoJSONException('invalid feature');
		}

		$arr['geometry'] = [
			'type'        => $this->type,
			'coordinates' => $this->coords,
		];

		if(!empty($this->bbox)){
			$arr['bbox'] = $this->bbox;
		}

		if(!empty($this->properties)){
			$arr['properties'] = $this->properties;
		}

		if(!empty($this->id)){
			$arr['properties']['id'] = $this->id; // leaflet
#			$arr['id']               = $this->id; // GMaps
		}

		return $arr;
	}

}
