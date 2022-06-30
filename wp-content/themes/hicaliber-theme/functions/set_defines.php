<?php 
	//FrontPage ID
	$frontpage_id = get_option( 'page_on_front' );
	define('FRONTPAGE_ID', ($frontpage_id) ? $frontpage_id : '' );
	
	//current theme Layout	
	$theme_layout = _get_field_value('g_site_theme','options');
	define('THEME_LAYOUT', ($theme_layout) ? $theme_layout : '' );


	$parent_theme = _get_field_value('site_parent_theme','options');
	define('MAIN_THEME', ($parent_theme) ? $parent_theme : '' );


	$main_contact_details = _get_field_value('contact_details', 'options');

	if($main_contact_details) {
	    define('MAIN_AGENT_NAME', ($main_contact_details['name']) ? $main_contact_details['name'] : '' );
	    define('MAIN_AGENT_POSITION', ($main_contact_details['position']) ? $main_contact_details['position'] : '' );
		define('MAIN_AGENT_PHONE', ($main_contact_details['phone_number']) ? $main_contact_details['phone_number'] : '' );
		define('MAIN_AGENT_EMAIL', ($main_contact_details['email_address']) ? $main_contact_details['email_address'] : '' );
		define('MAIN_AGENT_ADDRESS', ($main_contact_details['address_line_1']) ? $main_contact_details['address_line_1'] : '' );
		define('MAIN_ADDRESS_LINK', ($main_contact_details['address_google_link']) ? $main_contact_details['address_google_link'] : '' );
		define('MAIN_AGENT_ABN', ($main_contact_details['abn']) ? $main_contact_details['abn'] : '' );
	}
 ?>