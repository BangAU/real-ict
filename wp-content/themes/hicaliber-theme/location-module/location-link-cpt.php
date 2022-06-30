<?php

$field_is_required = 0;

$user = wp_get_current_user();	
if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
	if( in_array( 'administrator' , $user->roles ) ) {
		$field_is_required = 1;
	}
}
		


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b581d4b4f175',
	'title' => 'Location',
	'fields' => array(
		array(
			'key' => 'field_5b581c6f2b51c',
			'label' => 'Link to Location',
			'name' => 'link_to_location',
			'type' => 'post_object',
            'instructions' => 'Link this post to a location',
            'required' => $field_is_required,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'location',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
            'ui' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'location_post',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'location_page',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5b581d4b4f176',
	'title' => 'Location',
	'fields' => array(
		array(
			'key' => 'field_5b581c6f2b51d',
			'label' => 'Link to Location',
			'name' => 'link_to_location',
			'type' => 'post_object',
            'instructions' => 'Link this post to a location',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'location',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 1,
            'return_format' => 'id',
            'ui' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'team',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

?>