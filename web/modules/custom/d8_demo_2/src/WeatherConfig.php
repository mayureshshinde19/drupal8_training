<?php

namespace Drupal\d8_demo_2;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\Client;
use Drupal\Component\Serialization\Json;

class WeatherConfig {
	private $configs, $request;
	public function __construct(ConfigFactoryInterface $configs, Client $request) {
		$this->configs = $configs;
		$this->request = $request;
	}
	public function dummy() {
		kint ( $this->configs );
		kint ( $this->request );
	}
	public function getData($cityName) {
		$appid = $this->configs->get ( 'd8_demo_2.weather_config' )->get ( 'appid' );
		$response = $this->request->request ( 'GET', 'http://api.openweathermap.org/data/2.5/weather', [
				'query' => [
						'q' => $cityName,
						'appid' => $appid
				]
		] );
		return Json::decode ( $response->getBody ()->getContents () );
	}
}