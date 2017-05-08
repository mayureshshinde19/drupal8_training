<?php

namespace Drupal\d8_demo_2\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SimpleForm extends FormBase {
	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 *
	 */
	public function getFormId() {
		return 'simple_form';
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
		$form ['name'] = [
				'#type' => 'textfield',
				'#title' => 'name',
				'#description' => 'enter your name'
		];

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
		$name = $form_state->getValue ( 'name' );
		if (strlen ( $name ) <= 5) {
			$form_state->setErrorByName ( $name, 'Name should atleast contain five characters' );
		}
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
		drupal_set_message ( t ( 'The form has been submitted successfully!' ) );
	}
}