<?php

if( function_exists('acf_add_local_field_group') ):

$settings = array (
	'key' => 'group_5bedfa77d2114',
	'title' => 'Gallery Settings',
	'fields' => array (
		array (
			'key' => 'field_5bedfa77d8cd3',
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
		array (
			'key' => 'field_5bedfa77d8223',
			'label' => 'Single Page',
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
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d1c0231111e4',
			'label' => 'Banner Options',
			'name' => 'gallery_single_page_banner',
			'type' => 'group',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array (
				array(
					'key' => 'field_48bd1a908d111',
					'label' => 'Banner Display',
					'name' => 'show_page_banner',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						"id" => ''
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 1,
					'ui_on_text' => 'Show',
					'ui_off_text' => 'Hide',
				),
				array (
					'key' => 'field_67ad1a9012115',
					'label' => 'Default Banner Image',
					'name' => 'cp_page_banner',
					'type' => 'image',
					'value' => NULL,
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_48bd1a908d111',
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
					'key' => 'field_5b3da9d211121',
					'label' => 'Banner Height',
					'name' => 'page_banner_height',
					'type' => 'button_group',
					'instructions' => 'Select height of banner',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_48bd1a908d111',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '33.33',
						'class' => 'hidden',
						'id' => '',
					),
					'choices' => array (
						'default-height' => 'Default',
						'short-banner' => 'Short',
						'tall-banner' => 'Tall',
                		'full-screen-banner' => 'Full Screen'
					),
					'allow_null' => 0,
					'default_value' => '',
					'layout' => 'horizontal',
					'return_format' => 'value',
				),
				array(
					"key" => "field_5b3da9d237222",
					"label" => "Text Alignment",
					"name" => "page_banner_text_alignment",
					"type" => "button_group",
					"instructions" => "Select text alignment",
					"required" => 0,
					"conditional_logic" => array(
						array(
							array(
								"field" => "field_48bd1a908d111",
								"operator" => "==",
								"value" => "1"
							)
						)
					),
					"wrapper" => array(
						"width" => "33.33",
						"class" => "hidden",
						"id" => ""
					),
					"choices" => array(
						"default-alignment" => "Default",
						"text-left" => "Left",
						"text-center" => "Center",
						"text-right" => "Right"
					),
					"allow_null" => 0,
					"default_value" => "",
					"layout" => "horizontal",
					"return_format" => "value"
				),
				array(
					"key" => "field_5b3da9d234124",
					"label" => "Background Filter",
					"name" => "background_overlay",
					"type" => "extended-color-picker",
					"instructions" => "Add a filter over the image to make text stand out",
					"required" => 0,
					"conditional_logic" => array(
						array(
							array(
								"field" => "field_48bd1a908d111",
								"operator" => "==",
								"value" => "1"
							)
						)
					),
					"wrapper" => array(
						"width" => "33.33",
						"class" => "hidden",
						"id" => ""
					),
					"default_value" => "rgba(10,0,0,0.5)",
					"color_palette" => "rgba(10,0,0,0.5)",
					"hide_palette" => 0
				),
			),
		),
		array (
			'key' => 'field_5be4fa77d3f12',
			'label' => 'Page Builder Elements',
			'name' => 'gallery_pcb',
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
				'5bc42d1b53247' => array (
					'key' => '5bc42d1b53247',
					'name' => 'gallery_descrition',
					'label' => 'Description',
					'display' => 'block',
					'sub_fields' => array (
						array(
							'key' => 'field_5bc081119v214',
							'label' => 'Layout',
							'name' => 'gallery_layout',
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

								array (
									'key' => 'field_5b84e8e731333',
									'label' => 'Select Layout',
									'name' => 'gallery_type',
									'type' => 'button_group',
									'value' => NULL,
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'choices' => array (
										'grid' => 'Grid',
										'carousel' => 'Carousel',
									),
									'allow_null' => 0,
									'default_value' => 'grid',
									'layout' => 'horizontal',
									'return_format' => 'value',
								),

								array(
									'key' => 'field_5bc0811244131',
									'label' => 'Select Display',
									'name' => 'grid_display',
									'type' => 'select',
									'instructions' => '',
									'required' => 0,
									   'conditional_logic' => array(
			                            array(
			                                array(
			                                    'field' => 'field_5b84e8e731333',
			                                    'operator' => '==',
			                                    'value' => 'grid',
			                                ),			                                
			                            ),			                           
			                        ),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'choices' => array(
										'default-layout' => 'Default Layout',
										'image-above-content' => 'Gallery above content',
										'image-below-content' => 'Gallery below content',									
									),
									'default_value' => array(
									),
									'allow_null' => 0,
									'multiple' => 0,
									'ui' => 0,
									'return_format' => 'value',
									'ajax' => 0,
									'placeholder' => '',
								),
								array(
									'key' => 'field_5bc0811244132',
									'label' => 'Select Display',
									'name' => 'display',
									'type' => 'select',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => array(
			                            array(
			                                array(
			                                    'field' => 'field_5b84e8e731333',
			                                    'operator' => '!=',
			                                    'value' => 'grid',
			                                ),			                                
			                            ),			                           
			                        ),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'choices' => array(
										'default-layout' => 'Default Layout',
										'image-above-content' => 'Gallery above content',
										'image-below-content' => 'Gallery below content',
										'image-left-content split-40-60' => 'Gallery left of content (40% | 60%)',
										'image-left-content split-50-50' => 'Gallery left of content (50% | 50%)',
										'image-left-content split-60-40' => 'Gallery left of content (60% | 40%)',
										'image-right-content split-60-40' => 'Gallery right of content (60% | 40%)',
										'image-right-content split-50-50' => 'Gallery right of content (50% | 50%)',
										'image-right-content split-40-60' => 'Gallery right of content (40% | 60%)',
									),
									'default_value' => array(
									),
									'allow_null' => 0,
									'multiple' => 0,
									'ui' => 0,
									'return_format' => 'value',
									'ajax' => 0,
									'placeholder' => '',
								),
								array(
			                        'key' => 'field_5b1e78c74bedb',
			                        'label' => 'Boxes per row',
			                        'name' => 'per_row',
			                        'type' => 'select',
			                        'instructions' => '',
			                        'required' => 0,
			                         'conditional_logic' => array(
			                         	 array(
			                                array(
			                                    'field' => 'field_5bc0811244131',
			                                    'operator' => '==',
			                                    'value' => 'default-layout',
			                                ),			                                
			                            ),
			                            array(
			                                array(
			                                    'field' => 'field_5bc0811244131',
			                                    'operator' => '==',
			                                    'value' => 'image-above-content',
			                                ),			                                
			                            ),
			                             array(
			                                array(
			                                    'field' => 'field_5bc0811244131',
			                                    'operator' => '==',
			                                    'value' => 'image-below-content',
			                                ),			                                
			                            ),
			                        ),
			                        'wrapper' => array(
			                            'width' => '',
			                            'class' => '',
			                            'id' => '',
			                        ),
			                        'choices' => array(
			                            'medium-12' => '1 per row',
			                            'medium-6' => '2 per row',
			                            'medium-4' => '3 per row',
			                            'medium-6 large-3' => '4 per row',
			                            'medium-4 large-2_4' => '5 per row',
			                            'medium-4 large-2' => '6 per row',
			                        ),
			                        'default_value' => array(
			                            0 => 'medium-4',
			                        ),
			                        'allow_null' => 0,
			                        'multiple' => 0,
			                        'ui' => 1,
			                        'ajax' => 0,
			                        'return_format' => 'value',
			                        'placeholder' => '',
			                    ),
								array(
									'key' => 'field_5bc101a786424',
									'label' => 'Gallery Thumbnails',
									'name' => 'thumbnails',
									'type' => 'true_false',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => array(
			                            array(
			                                array(
			                                    'field' => 'field_5b84e8e731333',
			                                    'operator' => '==',
			                                    'value' => 'carousel',
			                                ),			                                
			                            ),			                           
			                        ),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'message' => 'Display thumbnail images below gallery',
									'default_value' => 1,
									'ui' => 1,
									'ui_on_text' => 'Show',
									'ui_off_text' => 'Hide',
								),
								array(
									'key' => 'field_5bc081119afca',
									'label' => 'Lightbox',
									'name' => 'lightbox',
									'type' => 'true_false',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'message' => 'Enable lightbox to display gallery images in popup',
									'default_value' => 0,
									'ui' => 1,
									'ui_on_text' => '',
									'ui_off_text' => '',
								),
							),
						
						),

						// array(
						// 	'key' => 'field_5bc27e4822233',
						// 	'label' => 'Gallery',
						// 	'name' => 'gallery_settings',
						// 	'type' => 'group',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => 0,
						// 	'wrapper' => array(
						// 		'width' => '',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'layout' => 'block',
						// 	'sub_fields' => array(
						// 		array (
						// 			'key' => 'field_5b84e8e731333',
						// 			'label' => 'Gallery Type',
						// 			'name' => 'gallery_type',
						// 			'type' => 'button_group',
						// 			'value' => NULL,
						// 			'instructions' => '',
						// 			'required' => 0,
						// 			'conditional_logic' => 0,
						// 			'wrapper' => array (
						// 				'width' => '',
						// 				'class' => '',
						// 				'id' => '',
						// 			),
						// 			'choices' => array (
						// 				'grid' => 'Grid',
						// 				'slider' => 'Slider',
						// 			),
						// 			'allow_null' => 0,
						// 			'default_value' => 'grid',
						// 			'layout' => 'horizontal',
						// 			'return_format' => 'value',
						// 		),
						// 		array(
						// 			'key' => 'field_5bc101a786424',
						// 			'label' => 'Gallery Thumbnails',
						// 			'name' => 'thumbnails',
						// 			'type' => 'true_false',
						// 			'instructions' => '',
						// 			'required' => 0,
						// 			'conditional_logic' => array (
						// 				array (
						// 					array (
						// 						'field' => 'field_5b84e8e731333',
						// 						'operator' => '==',
						// 						'value' => 'slider',
						// 					),
						// 				),
						// 			),
						// 			'wrapper' => array(
						// 				'width' => '50',
						// 				'class' => '',
						// 				'id' => '',
						// 			),
						// 			'message' => 'Display thumbnail images below gallery',
						// 			'default_value' => 0,
						// 			'ui' => 1,
						// 			'ui_on_text' => 'Show',
						// 			'ui_off_text' => 'Hide',
						// 		),
						// 		array (
						// 			'key' => 'field_5b1e78c74bedb',
						// 			'label' => 'Per Row',
						// 			'name' => 'per_row',
						// 			'type' => 'select',
						// 			'value' => NULL,
						// 			'instructions' => '',
						// 			'required' => 0,
						// 			'conditional_logic' => array (
						// 				array (
						// 					array (
						// 						'field' => 'field_5b84e8e731333',
						// 						'operator' => '==',
						// 						'value' => 'grid',
						// 					),
						// 				),
						// 			),
						// 			'wrapper' => array (
						// 				'width' => '50',
						// 				'class' => '',
						// 				'id' => '',
						// 			),
						// 			'choices' => array (
						// 				'medium-12' => '1 per row',
						// 				'medium-6' => '2 per row',
						// 				'medium-6 large-4' => '3 per row',
						// 				'medium-6 large-3' => '4 per row',
						// 			),
						// 			'default_value' => array (
						// 			),
						// 			'allow_null' => 0,
						// 			'multiple' => 0,
						// 			'ui' => 0,
						// 			'ajax' => 0,
						// 			'return_format' => 'value',
						// 			'placeholder' => '',
						// 		),
						// 		array(
						// 			'key' => 'field_5bc081119afca',
						// 			'label' => 'Lightbox',
						// 			'name' => 'lightbox',
						// 			'type' => 'true_false',
						// 			'instructions' => '',
						// 			'required' => 0,
						// 			'conditional_logic' => 0,
						// 			'wrapper' => array(
						// 				'width' => '50',
						// 				'class' => '',
						// 				'id' => '',
						// 			),
						// 			'message' => 'Enable lightbox to display gallery images in popup',
						// 			'default_value' => 0,
						// 			'ui' => 1,
						// 			'ui_on_text' => '',
						// 			'ui_off_text' => '',
						// 		),
						// 	),
						// ),
						array(
							'key' => 'field_5bc081119b0af',
							'label' => 'Design',
							'name' => 'cpts_desc_gallery_design',
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
				'5bc4312339212' => array (
					'key' => '5bc4312339212',
					'name' => 'single_gallery_related',
					'label' => 'Related Gallery',
					'display' => 'block',
					'sub_fields' => array (
					        
					       array (
							'key' => 'field_5bc4312823421',
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
							'key' => 'field_5bc33243292c6',
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
							'key' => 'field_5bc081119b232',
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
				'5bc433d38949a' => array (
					'key' => '5bc433d38949a',
					'name' => 'global_element',
					'label' => 'Global Element',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_5bedfa77f0a5d',
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
		array (
			'key' => 'field_5cbe157a61123',
			'label' => 'Category Page',
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
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d1c0238211e4',
			'label' => 'Banner Options',
			'name' => 'gallery_cat_banner',
			'type' => 'group',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array (
				array(
					'key' => 'field_48bd1a908d332',
					'label' => 'Banner Display',
					'name' => 'show_page_banner',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						"id" => ''
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 1,
					'ui_on_text' => 'Show',
					'ui_off_text' => 'Hide',
				),
				array (
					'key' => 'field_67ad1a9012073',
					'label' => 'Default Banner Image',
					'name' => 'cp_page_banner',
					'type' => 'image',
					'value' => NULL,
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_48bd1a908d332',
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
					'key' => 'field_5b3da9d233123',
					'label' => 'Banner Height',
					'name' => 'page_banner_height',
					'type' => 'button_group',
					'instructions' => 'Select height of banner',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_48bd1a908d332',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '33.33',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'default-height' => 'Default',
						'short-banner' => 'Short',
						'tall-banner' => 'Tall',
                		'full-screen-banner' => 'Full Screen'
					),
					'allow_null' => 0,
					'default_value' => '',
					'layout' => 'horizontal',
					'return_format' => 'value',
				),
				array(
					"key" => "field_5b3da9d237134",
					"label" => "Text Alignment",
					"name" => "page_banner_text_alignment",
					"type" => "button_group",
					"instructions" => "Select text alignment",
					"required" => 0,
					"conditional_logic" => array(
						array(
							array(
								"field" => "field_48bd1a908d332",
								"operator" => "==",
								"value" => "1"
							)
						)
					),
					"wrapper" => array(
						"width" => "33.33",
						"class" => "",
						"id" => ""
					),
					"choices" => array(
						"default-alignment" => "Default",
						"text-left" => "Left",
						"text-center" => "Center",
						"text-right" => "Right"
					),
					"allow_null" => 0,
					"default_value" => "",
					"layout" => "horizontal",
					"return_format" => "value"
				),
				array(
					"key" => "field_5b3da9d233313",
					"label" => "Background Filter",
					"name" => "background_overlay",
					"type" => "extended-color-picker",
					"instructions" => "Add a filter over the image to make text stand out",
					"required" => 0,
					"conditional_logic" => array(
						array(
							array(
								"field" => "field_48bd1a908d332",
								"operator" => "==",
								"value" => "1"
							)
						)
					),
					"wrapper" => array(
						"width" => "33.33",
						"class" => "",
						"id" => ""
					),
					"default_value" => "rgba(10,0,0,0.5)",
					"color_palette" => "rgba(10,0,0,0.5)",
					"hide_palette" => 0
				),
			),
		),

		array (
			'key' => 'field_6cd6265fc1343',
			'label' => 'Page Element Builder',
			'name' => 'gallery_cat_element_builder',
			'type' => 'flexible_content',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layouts' => array (
				'4bc42d1b5314' => array (
					'key' => '4bc42d1b5314',
					'name' => 'category_description',
					'label' => 'Description',
					'display' => 'block',
					'sub_fields' => array (
					    
					    
					    	array(
							'key' => 'field_5bc081119dr13',
							'label' => 'Layout',
							'name' => 'gallery_category_desc_layout',
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
									'key' => 'field_5bc1311234231',
									'label' => 'Select Display',
									'name' => 'display',
									'type' => 'select',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'choices' => array(
									    'content-only' => 'Content Only',
										'image-above-content' => 'Featured Image above content',
										'image-overlay-content' => 'Featured Image overlay content centered',
										'image-left-content split-40-60' => 'Featured Image left of content (40% | 60%)',
										'image-left-content split-50-50' => 'Featured Image left of content (50% | 50%)',
										'image-right-content split-60-40' => 'Featured Image right of content (60% | 40%)',
										'image-right-content split-50-50' => 'Featured Image right of content (50% | 50%)',
										'image-right-content split-40-60' => 'Featured Image right of content (40% | 60%)',
									),
									'default_value' => array(
									),
									'allow_null' => 0,
									'multiple' => 0,
									'ui' => 0,
									'return_format' => 'value',
									'ajax' => 0,
									'placeholder' => '',
								),
							),
						),
					    

						array (
							'key' => 'field_5bc42d0b1a123',
							'label' => 'Descriptions',
							'name' => 'description',
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
								0 => 'field_5b8e79de0c3a1',
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
				'5bc4312889413' => array (
					'key' => '5bc4312889413',
					'name' => 'category_gallery_listing',
					'label' => 'Gallery Listing',
					'display' => 'block',
					'sub_fields' => array (
					        
					array(
                        'key' => 'field_5b2e19de0c313',
                        'label' => 'Layout',
                        'name' => 'category_gallery_listing_layout',
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
                        'key' => 'field_53743135ad839',
                        'label' => 'Select Grid Layout',
                        'name' => 'display',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'default-grid-layout' => 'Default Layout',
                            'grid-layout-1' => 'Grid Layout 1',
                            'grid-layout-2' => 'Grid Layout 2',
                            'grid-layout-3' => 'Grid Layout 3',
                        ),
                        'default_value' => array(
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => '',
                    ),
                     array(
                        'key' => 'field_5b0a1241df423',
                        'label' => 'Images per row',
                        'name' => 'per_row',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'medium-12' => '1 per row',
                            'medium-6' => '2 per row',
                            'medium-6 large-4' => '3 per row',
                            'medium-6 large-3' => '4 per row',
                            'medium-4 large-2_4' => '5 per row',
                            'medium-4 large-2' => '6 per row',
                        ),
                        'default_value' => array(
                            0 => 'medium-4',
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'return_format' => 'value',
                        'placeholder' => '',
                    ),
                   ),
                   
					  
					  ), 
							array(
							'key' => 'field_5bc081119b031',
							'label' => 'Design',
							'name' => 'category_gallery_listing_design',
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
				'5bc433d389313' => array (
					'key' => '5bc433d389313',
					'name' => 'global_element',
					'label' => 'Global Element',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_5bc433d38941c',
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
								0 => 'field_5bac2c795ee2e',
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
				'value' => 'acf-options-gallery-settings',
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