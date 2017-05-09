<?php

namespace Drupal\d8_demo_2\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Drupal\d8_demo_2\Event\CustomEvent;

class NewForm extends ConfigFormBase {
	private $event;
	public function __construct(ConfigFactoryInterface $config_factory, ContainerAwareEventDispatcher $event) {
		parent::__construct ( $config_factory );
		$this->event = $event;
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'config.factory' ), $container->get ( 'event_dispatcher' ) );
	}
	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 *
	 */
	public function getFormId() {
		return 'weather_config';
	}

	/**
	 * Form constructor.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 * @return array The form structure.
	 *
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['appid'] = [
				'#type' => 'textfield',
				'#title' => 'Weather app API Key',
				'#description' => 'enter your APP ID',
				'#default_value' => $this->config ( 'd8_demo_2.weather_config' )->get ( 'appid', $form_state->getValue ( 'appid' ) )
		];

		return parent::buildForm ( $form, $form_state );
	}

	/**
	 * Form validation handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
	}

	/**
	 * Form submission handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// Display result.
		$this->config ( 'd8_demo_2.weather_config' )->set ( 'appid', $form_state->getValue ( 'appid' ) )->save ();
		parent::submitForm ( $form, $form_state );
		$eventObject = new CustomEvent ( $form_state->getValue ( 'appid' ) );
		$this->event->dispatch ( CustomEvent::WEATHER_CONFIG_UPDATE, $eventObject );
	}
	/**
	 * Gets the configuration names that will be editable.
	 *
	 * @return array An array of configuration object names that are editable if called in
	 *         conjunction with the trait's config() method.
	 */
	protected function getEditableConfigNames() {
		return [
				'd8_demo_2.weather_config'
		];
	}
}