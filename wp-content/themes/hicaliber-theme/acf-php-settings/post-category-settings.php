<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5bee1586ce15b',
	'title' => 'Categories Settings',
	'fields' => array (
	    
	    array(
			'key' => 'field_5b581cs123213',
			'label' => 'Featured',
			'name' => 'category_featured',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),

		array (
			'key' => 'field_6d065543b1141',
			'label' => 'Banner Image',
			'name' => 'pc_banner_image',
			'type' => 'image',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_6d05f644c2255',
			'label' => 'Featured Image',
			'name' => 'pc_featured_image',
			'type' => 'image',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		 array(
                'key' => 'field_5d1c012b31fex',
                'label' => 'Main description',
                'name' => 'pc_main_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
	),
	'location' => array (
		array (
			array (
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'category',
			),
		),
		array (
			array (
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'events_cat',
			),
		),
		array (
			array (
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'course_cat',
			),
		),
		array (
			array (
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'gallery_cat',
			),
		),
		array (
			array (
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'room-type_cat',
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
));

endif;