<?php

if( function_exists('acf_add_local_field_group') ):

$settings = array (
	'key' => 'group_5bdd323712332',
	'title' => 'Testimonials Settings',
	'fields' => array (
		array (
			'key' => 'field_5bedfa7721313',
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
            'key' => 'field_5adba522053e6',
            'label' => 'Single Page',
            'name' => 'testi_exclude_from_search',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => 'This is to disable the post single page',
            'default_value' => 1,
            'ui' => 1,
            'ui_on_text' => 'Enable',
            'ui_off_text' => 'Disable',
        ),
		array(
			'key' => 'field_5bec2e7201331',
			'label' => 'Slug',
			'name' => 'testi_slug',
			'type' => 'text',
			'instructions' => 'Please make sure to save <a href=\'options-permalink.php\' target=\'_blank\'>permalink</a> settings after you update this field. Please also take note that if slug have equivalent page slug, the archive will be automatically disabled.',
			'required' => 0,
			'conditional_logic' => array (
						array (
							array (
								'field' => 'field_5adba522053e6',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'testimonial',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array (
			'key' => 'field_5bedfa2323225',
			'label' => 'Single Page',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
						array (
							array (
								'field' => 'field_5adba522053e6',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),		
		array (
			'key' => 'field_5ce4fa7442133',
			'label' => 'Page Builder Elements',
			'name' => 'testi_pcb',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layouts' => array (
				'5bc42d1b53245' => array (
					'key' => '5bc42d1b53245',
					'name' => 'testi_descrition',
					'label' => 'Testimonial',
					'display' => 'block',
					'sub_fields' => array (
						
						array(
							'key' => 'field_5bc081112113f',
							'label' => 'Design',
							'name' => 'cpts_desc_testi_design',
							'type' => 'clone',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'clone' => array(
								0 => 'group_5bac772faef77',
							),
							'display' => 'group',
							'layout' => 'block',
							'prefix_label' => 0,
							'prefix_name' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
				'5bc4312330335' => array (
					'key' => '5bc4312330335',
					'name' => 'testi_listing',
					'label' => 'Testimonial Listing',
					'display' => 'block',
					'sub_fields' => array (
					        
					       array (
							'key' => 'field_5bc4313834221',
							'label' => 'Layout',
							'name' => 'layout',
							'type' => 'clone',
							'value' => NULL,
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'clone' => array (
								0 => 'field_5bc081119a883',
							),
							'display' => 'seamless',
							'layout' => '',
							'prefix_label' => 0,
							'prefix_name' => 0,
						),
						array (
							'key' => 'field_5bc33233192d0',
							'label' => 'Related Header',
							'name' => 'header',
							'type' => 'clone',
							'value' => NULL,
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'clone' => array (
								0 => 'field_5bc081119a8fc',
							),
							'display' => 'seamless',
							'layout' => '',
							'prefix_label' => 0,
							'prefix_name' => 0,
						),

						 array(
                'key' => 'field_5b8e79de0c134',
                'label' => 'Content',
                'name' => 'testi_content',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5bf22357c2323',
                        'label' => 'Full Content',
                        'name' => 'full_content',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => 'Show full testimonial content',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_5bbac2d344cde',
                        'label' => 'Select Categories',
                        'name' => 'categories',
                        'type' => 'taxonomy',
                        'instructions' => 'Selected categories to display',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'taxonomy' => 'testimonials_cat',
                        'field_type' => 'checkbox',
                        'add_term' => 1,
                        'save_terms' => 0,
                        'load_terms' => 0,
                        'return_format' => 'id',
                        'multiple' => 0,
                        'allow_null' => 0,
                    ),
                    array(
                        'key' => 'field_5bacd8a928331',
                        'label' => 'Listing Display',
                        'name' => 'testimonials_featured',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'recent' => 'Recent',
                            'featured' => 'Featured',
                            'random' => 'Random',
                            'select' => 'Select',
                        ),
                        'allow_null' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5bacd8df11134',
                        'label' => 'Max number of Posts',
                        'name' => 'testimonials_qty',
                        'type' => 'number',
                        'instructions' => 'Leave blank to show all posts',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => 3,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => 1,
                        'max' => 12,
                        'step' => '',
                    ),
                     array(
                        'key' => 'field_5e510ae1cd134',
                        'label' => 'Testimonial',
                        'name' => 'selected_testimonial',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                         'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5bacd8a928331',
                                    'operator' => '==',
                                    'value' => 'select',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'testimonials_type',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 1,
                        'return_format' => 'id',
                        'ui' => 1,
                    ),
                ),
            ),
				
							array(
							'key' => 'field_5bc081119d325',
							'label' => 'Design',
							'name' => 'related_design',
							'type' => 'clone',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'clone' => array(
								0 => 'group_5bac772faef77',
							),
							'display' => 'group',
							'layout' => 'block',
							'prefix_label' => 0,
							'prefix_name' => 0,
						),
											
					),
					'min' => '',
					'max' => '',
				),
				'5bc433d38940b' => array (
					'key' => '5bc433d38940b',
					'name' => 'global_element',
					'label' => 'Global Element',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_5bedfa77f0v14',
							'label' => 'Global Element',
							'name' => 'global_element',
							'type' => 'clone',
							'value' => NULL,
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'clone' => array (
								0 => 'field_5bc081119b803',
							),
							'display' => 'seamless',
							'layout' => 'block',
							'prefix_label' => 0,
							'prefix_name' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
			),
			'button_label' => 'Add Element',
			'min' => '',
			'max' => '',
		),
		

		
	
	

	),
		
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-review-setting',
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