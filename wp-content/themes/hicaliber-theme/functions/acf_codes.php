<?php

// ACF

if( function_exists('acf_add_options_page') ) {
 
   	acf_add_options_page( array( 
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'icon_url' 		=> 'dashicons-admin-settings',
		'capability'	=> 'update_themes'
	));

}

if( function_exists('acf_add_options_page') ) {
 
   	acf_add_options_page( array( 
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'icon_url' 		=> 'dashicons-admin-settings',
		'capability'	=> 'edit_theme_options'
	));

}