<?php

namespace Drupal\d8_demo_2\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8_demo_2\WeatherConfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Block(
 * id="Weather_block",
 * admin_label="Weather Block"
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {
	private $weatherConfig;
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherConfig $weatherConfig) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->weatherConfig = $weatherConfig;
	}
	public function build() {
		// kint ( $this->configuration ['city_name'] );
		$weather_data = $this->weatherConfig->getData ( $this->configuration ['city_name'] );
		return array (
				// '#markup' => 'Hello World!'
				'#theme' => 'weather_widget',
				'#weather_data' => $weather_data,
				'#attached' => [
						'library' => [
								'd8_demo_2/weather-widget'
						]
				]
		);
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function blockForm($form, FormStateInterface $form_state) {
		$form ['city_name'] = array (
				'#type' => 'textfield',
				'#title' => 'City Name',
				'#description' => 'Input the city name',
				'#default_value' => $this->configuration ['city_name']
		);
		return $form;
	}
	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->configuration ['city_name'] = $form_state->getValue ( 'city_name' );
	}
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'd8_demo_2.weatherconfig' ) );
	}
}