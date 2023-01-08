<?php
/**
 * Class FeatureCollection
 *
 * @created      25.06.2018
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

use function array_map;

/**
 * @see https://www.rfc-editor.org/rfc/rfc7946#section-3.3
 */
class FeatureCollection extends GeoJSONAbstract{

	/** @var \chillerlan\GeoJSON\Feature[] */
	protected array $features = [];

	/**
	 * FeatureCollection constructor.
	 *
	 * @param \chillerlan\GeoJSON\Feature[]|null $features
	 */
	public function __construct(iterable $features = null){

		if(!empty($features)){
			$this->addFeatures($features);
		}

	}

	/**
	 *
	 */
	public function addFeature(Feature $feature):FeatureCollection{
		$this->features[] = $feature;

		return $this;
	}

	/**
	 * @param \chillerlan\GeoJSON\Feature[] $features
	 */
	public function addFeatures(iterable $features):FeatureCollection{

		foreach($features as $feature){
			if($feature instanceof Feature){
				$this->addFeature($feature);
			}
		}

		return $this;
	}

	/**
	 *
	 */
	public function clearFeatures():FeatureCollection{
		$this->features = [];

		return $this;
	}

	/**
	 *
	 */
	public function toArray():array{
		$arr = ['type' => 'FeatureCollection'];

		if(!empty($this->bbox)){
			$arr['bbox'] = $this->bbox;
		}

		$arr['features'] = array_map(fn(Feature $feature):array => $feature->toArray(), $this->features);

		return $arr;
	}

}
