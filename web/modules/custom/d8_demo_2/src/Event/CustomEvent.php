<?php

namespace Drupal\d8_demo_2\Event;

use Symfony\Component\EventDispatcher\Event;

class CustomEvent extends Event {
	private $appid;
	const WEATHER_CONFIG_UPDATE = 'weather.config.update';
	public function __construct($appid) {
		$this->appid = $appid;
	}
	public function getAppid() {
		return $this->appid;
	}
}