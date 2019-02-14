<?php
/**
 * Class FeatureCollection
 *
 * @link https://tools.ietf.org/html/rfc7946
 *
 * @filesource   FeatureCollection.php
 * @created      25.06.2018
 * @package      chillerlan\GeoJSON
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2018 smiley
 * @license      MIT
 */

namespace chillerlan\GeoJSON;

class FeatureCollection extends GeoJSONAbstract{

	/**
	 * @var array
	 */
	protected $features = [];

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
	 * @param \chillerlan\GeoJSON\Feature $feature
	 *
	 * @return \chillerlan\GeoJSON\FeatureCollection
	 */
	public function addFeature(Feature $feature):FeatureCollection{
		$this->features[] = $feature;

		return $this;
	}

	/**
	 * @param Feature[] $features
	 *
	 * @return \chillerlan\GeoJSON\FeatureCollection
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
	 * @return \chillerlan\GeoJSON\FeatureCollection
	 */
	public function clearFeatures():FeatureCollection{
		$this->features = [];

		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray():array{
		$arr = ['type' => 'FeatureCollection'];

		if(!empty($this->bbox)){
			$arr['bbox'] = $this->bbox;
		}

		$arr['features'] = array_map(function(Feature $feature){
			return $feature->toArray();
		}, $this->features);

		return $arr;
	}

}
