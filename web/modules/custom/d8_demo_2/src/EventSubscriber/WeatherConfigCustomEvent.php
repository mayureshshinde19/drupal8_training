<?php

namespace Drupal\d8_demo_2\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\d8_demo_2\Event\CustomEvent;

class WeatherConfigCustomEvent implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		return [
				CustomEvent::WEATHER_CONFIG_UPDATE => [
						'addMessage'
				]
		];
	}
	public function addMessage(CustomEvent $event) {
		drupal_set_message ( $event->getAppid () );
	}
}