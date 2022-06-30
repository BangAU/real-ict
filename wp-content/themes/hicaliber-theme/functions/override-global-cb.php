<?php 

	/** Add Advance Settings tab : Page Edit / Page builder Template **/
add_action("init", "add_advance_settings_page_builder_content");

function add_advance_settings_page_builder_content(){
	if( function_exists('acf_add_local_field') ):
		//Register Advance Settings Tab
		 acf_add_local_field(
	 			array(
	 				'parent' => 'group_5b8e79dde9950',
	                'key' => 'field_5bc981919b23132',
	                'label' => 'Advance Settings',
	                'name' => '',
	                'type' => 'tab',
	                'instructions' => '',
	                'required' => 0,
	                'conditional_logic' => array(
	                    array(
	                        array(
	                            'field' => 'field_5b8e7a10e7e6a',
	                            'operator' => '==',
	                            'value' => 'global_element',
	                        ),
							array(
					            'field' => 'field_5bac2c795ee2e', 
					            'operator' => '==',
					            'value' => 'content_boxes',
					        )
	                    ),
	                ),
	                'wrapper' => array(
	                    'width' => '',
	                    'class' => '',
	                    'id' => '',
	                ),
	                'placement' => 'left',
	                'endpoint' => 0,
	            )
		);
	 	//TRUE / FALSE Enable Override
	 	acf_add_local_field(
				array(
					'parent' => 'group_5b8e79dde9950',
	                'key' => 'field_5bc981919b23137',
	                'label' => 'Enable Override',
	                'name' => 'ge_advance_settings_enable_override',
	                'type' => 'true_false',
	                'instructions' => '',
	                'required' => 0,
	                'conditional_logic' => array(
	                    array(
	                        array(
	                            'field' => 'field_5b8e7a10e7e6a',
	                            'operator' => '==',
	                            'value' => 'global_element',
	                        ),
	                    ),
	                ),
	                'wrapper' => array(
	                    'width' => '',
	                    'class' => '',
	                    'id' => '',
	                ),
	                'message' => '',
	                'default_value' => 0,
	                'ui' => 1,
	                'ui_on_text' => 'Enable',
	                'ui_off_text' => 'Disable',
	            )
			);
	 	//Layout
	 	acf_add_local_field(
	            array(
	            	'parent' => 'group_5b8e79dde9950',
	                'key' => 'field_5bc981919b23133',
	                'label' => '',
	                'name' => 'ge_advance_settings_layout',
	                'type' => 'clone',
	                'instructions' => '',
	                'required' => 0,
	                'conditional_logic' => array(
	                    array(
	                        array(
	                            'field' => 'field_5bc981919b23137',
	                            'operator' => '==',
	                            'value' => 1,
	                        ),
	                    ),
	                ),
	                'wrapper' => array(
	                    'width' => '',
	                    'class' => '',
	                    'id' => '',
	                ),
	                'clone' => array(
	                    0 => 'field_5b8e79de0c374',
	                ),
	                'display' => 'group',
	                'layout' => 'block',
	                'prefix_label' => 0,
	                'prefix_name' => 0,
	            )

	 	);
	 	//Header
	 	acf_add_local_field(
			array(
					'parent' => 'group_5b8e79dde9950',
	                'key' => 'field_5bc981919b23134',
	                'label' => '',
	                'name' => 'ge_advance_settings_header',
	                'type' => 'clone',
	                'instructions' => '',
	                'required' => 0,
	                'conditional_logic' => array(
	                    array(
	                        array(
	                            'field' => 'field_5bc981919b23137',
	                            'operator' => '==',
	                            'value' => 1,
	                        ),
	                    ),
	                ),
	                'wrapper' => array(
	                    'width' => '',
	                    'class' => '',
	                    'id' => '',
	                ),
	                'clone' => array(
	                    0 => 'field_5b90d7c58b72c',
	                ),
	                'display' => 'group',
	                'layout' => 'block',
	                'prefix_label' => 0,
	                'prefix_name' => 0,
	            )

	 	);
	 	//Footer
	 	acf_add_local_field(
			array(
					'parent' => 'group_5b8e79dde9950',
	                'key' => 'field_5bc981919b23135',
	                'label' => '',
	                'name' => 'ge_advance_settings_footer',
	                'type' => 'clone',
	                'instructions' => '',
	                'required' => 0,
	                'conditional_logic' => array(
	                    array(
	                        array(
	                            'field' => 'field_5bc981919b23137',
	                            'operator' => '==',
	                            'value' => 1,
	                        ),
	                    ),
	                ),
	                'wrapper' => array(
	                    'width' => '',
	                    'class' => '',
	                    'id' => '',
	                ),
	                'clone' => array(
	                    0 => 'field_5b8e79de0c396',
	                ),
	                'display' => 'group',
	                'layout' => 'block',
	                'prefix_label' => 0,
	                'prefix_name' => 0,
	            )
	 	);
	 	//Design
	 	acf_add_local_field(
			array(
					'parent' => 'group_5b8e79dde9950',
	                'key' => 'field_5bc981919b23136',
	                'label' => '',
	                'name' => 'ge_advance_settings_design',
	                'type' => 'clone',
	                'instructions' => '',
	                'required' => 0,
	                'conditional_logic' => array(
	                    array(
	                        array(
	                            'field' => 'field_5bc981919b23137',
	                            'operator' => '==',
	                            'value' => 1,
	                        ),
	                    ),
	                ),
	                'wrapper' => array(
	                    'width' => '',
	                    'class' => '',
	                    'id' => '',
	                ),
	                'clone' => array(
	                    0 => 'field_5b8e79de0c3a1',
	                ),
	                'display' => 'group',
	                'layout' => 'block',
	                'prefix_label' => 0,
	                'prefix_name' => 0,
	            )

	 	);
	endif;
}



//Override conditional logic for enable/disable override content box and advance setting tab
add_filter("acf/load_field/key=field_5bc981919b23132", 'hical_advance_setting_conditionals');
add_filter("acf/load_field/key=field_5bc981919b23137", 'hical_advance_setting_conditionals');

function hical_advance_setting_conditionals($field){
	$field["conditional_logic"] = hical_advance_setting_content_boxes_conditional_logic($field);
	return $field;
}

function hical_advance_setting_content_boxes_conditional_logic($field){
	//PE G SELECT KEY = field_5bac2c795ee2e
	$globalField = "ge_elements";

	$conditional_logic =  $field["conditional_logic"];

	#-- taken from acfPrePopulateChoices.php
    // if has rows
    if( _have_rows($globalField, 'options') ) {
        // while has rows
        while( _have_rows($globalField, 'options') ) {
            // instantiate row
            the_row();
            $value = get_row_index() - 1;
            $element_type = _get_sub_field_value('ge_select_element');

           	//include in conditional logic if content boxes
            if($element_type == "content_boxes"):
				$conditional_logic[] = array(
					array(
			            'field' => 'field_5b8e7a10e7e6a',
			            'operator' => '==',
			            'value' => 'global_element'
			        ),
					array(
			            'field' => 'field_5bac2c795ee2e', 
			            'operator' => '==',
			            'value' => $value . "|" . $element_type,
			        )
				);
			endif;
        }
    }
    return $conditional_logic;
}


function hical_repeater_pre_populate_field_choices($field, $globalField){

    // reset choices
    $field['choices'] = array();
    
    // if has rows
    if( _have_rows($globalField, 'options') ) {
        
        // while has rows
        while( _have_rows($globalField, 'options') ) {
            
            // instantiate row
            the_row();

            // vars
            $label = _get_sub_field_value('g_elem_label') ? _get_sub_field_value('g_elem_label') : "Global Element #".get_row_index();
            $value = get_row_index() - 1;
            $element_type = _get_sub_field_value('ge_select_element');

            // append to choices : [ $value ] -- old
            $field['choices'][  $value . "|" . $element_type ] = "<div class='pe-choices-container ".$value."'><img src='".ASSETS_IMG.'element-images/'.$element_type.".jpg' /><div class='element-label'>".$label."</div></div>";
            
        }
        
    }

    // return the field
    return $field;
}

function hical_acf_load_global_elem_choices( $field ) {
    return hical_repeater_pre_populate_field_choices($field, 'ge_elements');
}

add_filter('acf/load_field/name=pe_g_select', 'hical_acf_load_global_elem_choices', 99);