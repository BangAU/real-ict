<?php

if( function_exists('acf_add_local_field_group') ):

$settings = array (
	'key' => 'group_5beffa77d2979',
	'title' => 'Location Post Settings',
	'fields' => array (
        array (
			'key' => 'field_5eeefa77d8ff7',
			'label' => 'General',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5eee2e7201334',
			'label' => 'Slug',
			'name' => 'location_page_slug',
			'type' => 'text',
			'instructions' => 'Please make sure to save <a href=\'options-permalink.php\' target=\'_blank\'>permalink</a> settings after you update this field. Please also take note that if slug have equivalent page slug, the archive will be automatically disabled.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'location_page',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-location-page-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
);

acf_add_local_field_group($settings);

endif;