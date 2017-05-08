<?php

namespace Drupal\d8_demo_2\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_demo_2\DbWrapper;

class SecondForm extends FormBase {
	private $dbWrapper;
	public function __construct(DbWrapper $dbWrapper) {
		$this->dbWrapper = $dbWrapper;
	}
	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 *
	 */
	public function getFormId() {
		return 'second_form';
	}

	/**
	 * Form constructor.
	 * W
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
		$data = $this->dbWrapper->getData ();
		$form ['firstname'] = [
				'#type' => 'textfield',
				'#title' => 'First Name',
				'#description' => 'Enter your first name',
				'#default_value' => $data ['firstname']
		];
		// '#default_value' => $data ['firstname']

		$form ['lastname'] = [
				'#type' => 'textfield',
				'#title' => 'Last Name',
				'#description' => 'Enter your last name',
				'#default_value' => $data ['lastname']
		];
		// '#default_value' => $data ['lastname']

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => 'Submit here'
		];

		return $form;
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
		// $name = $form_state->getValue ( 'firstname' );
		// if (strlen ( $name ) <= 5) {
		// $form_state->setErrorByName ( $name, 'Name should atleast contain five characters' );
		// }
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
		// drupal_set_message ( t ( 'The form has been submitted successfully!' ) );
		$this->dbWrapper->setData ( $form_state->getValue ( 'firstname' ), $form_state->getValue ( 'lastname' ) );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'd8_demo_2.dbwrapper' ) );
	}
}