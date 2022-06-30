<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5a9607a45144a',
	'title' => 'Page Content Builder',
	'fields' => array(
		array(
			'key' => 'field_5a9607a457c4a',
			'label' => 'Page Content',
			'name' => 'page_content_builder',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layouts' => array(
				'5a96613798501' => array(
					'key' => '5a96613798501',
					'name' => 'page_content',
					'label' => 'Column Content',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bb2cbcd7f155',
							'label' => 'Section Admin Label',
							'name' => 'layout_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5bb6275de53e5',
							'label' => 'Elements / Sections',
							'name' => 'columns',
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
								0 => 'group_5bb61c7558ea4',
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
				'5ae5c0d44e496' => array(
					'key' => '5ae5c0d44e496',
					'name' => 'page_elements',
					'label' => 'Page Elements',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5ae5c6f8f1453',
							'label' => 'Section Admin Label',
							'name' => 'layout_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5bb2cc967f156',
							'label' => 'Elements / Sections',
							'name' => 'elements',
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
								0 => 'group_5b8e79dde9950',
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
			),
			'button_label' => 'Add Content',
			'min' => '',
			'max' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template-page-builder.php',
			),
		),		
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template-cpt-archive.php',
			),
		),
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'woo_shop_page',
			)
		),
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => -1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'discussion',
		1 => 'comments',
	),
	'active' => 1,
	'description' => '',
));

endif;
?>