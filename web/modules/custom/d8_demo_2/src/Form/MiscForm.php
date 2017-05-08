<?php

namespace Drupal\d8_demo_2\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\State;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\State\StateInterface;

/**
 * Class MiscForm.
 *
 * @package Drupal\d8_demo_2\Form
 */
class MiscForm extends FormBase {
	private $state;
	protected $database;
	public function __construct(StateInterface $state) {
		$this->state = $state;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function getFormId() {
		return 'misc_form';
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		kint ( $this->state );
		$form ['qualifications'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Qualifications' ),
				'#options' => array (
						'UG' => $this->t ( 'UG' ),
						'PG' => $this->t ( 'PG' ),
						'Other' => $this->t ( 'Other' )
				),
				'#size' => 5
		];
		$form ['qualifications_other'] = [
				'#type' => 'textfield',
				'#title' => $this->t ( 'Qualifications' ),
				'#maxlength' => 64,
				'#size' => 64,
				'#states' => [
						'visible' => [
								':input[name="qualifications"]' => [
										'value' => 'Other'
								]
						]
				]
		];
		$form ['country'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Select Country' ),
				'#options' => array (
						'India' => $this->t ( 'India' ),
						'UK' => $this->t ( 'UK' )
				),
				'#ajax' => [
						'callback' => 'Drupal\d8_demo_2\Form\MiscForm::populateStates',
						'wrapper' => 'ajax-callback-wrapper'
				],
				'#default_value' => $this->state->get ( 'country' )
		];

		$form ['ajax-container'] = [
				'#type' => 'container',
				'#attributes' => [
						'id' => 'ajax-callback-wrapper'
				]
		];

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => $this->t ( 'Submit' )
		];

		return $form;
	}
	public function populateStates(array &$form, FormStateInterface $form_state) {
		$country = $form_state->getValue ( 'country' );
		$states ['India'] = [
				'MH',
				'TN',
				'MP'
		];
		$states ['UK'] = [
				'London',
				'Manchester',
				'Blackpool'
		];

		$form ['ajax-container'] ['states'] = [
				'#type' => 'select',
				'#options' => $states [$country]
		];
		return $form ['ajax-container'];
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		parent::validateForm ( $form, $form_state );
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// Display result.
		foreach ( $form_state->getValues () as $key => $value ) {
			// drupal_set_message ( $key . ': ' . $value );
			$this->state->set ( $key, $value );
		}
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'state' ) );
	}
}
