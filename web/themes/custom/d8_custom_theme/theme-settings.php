<?php
use Drupal\Core\Form\FormStateInterface;
function d8_custom_theme_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
	$form ['site_sub_slogan'] = array (
			'#type' => 'textfield',
			'#description' => t ( 'SIte sub slogan' ),
			'#title' => 'Site SLogan',
			'#default_value' => theme_get_setting ( 'site_sub_slogan' )
	);
	return $form;
}