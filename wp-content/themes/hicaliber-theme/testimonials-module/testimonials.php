<?php

require_once( 'testimonial-settings-acf.php' );
require_once( 'testi-functions.php' );

  add_filter( 'single_template', function( $single_template ) {
    		global $post;
    	    $template = get_template_directory() . '/testimonials-module/single-testimonials.php';
    	    if( $post->post_type == 'testimonials_type' && is_readable( $template ) )
    	        $single_template =  $template;
    	    return $single_template;
    });


$evh = new hcElementController(_get_field_value('sites_elements', 'options'));
if($evh::isVisible('testimonials', true)) :
	
	require_once 'testimonials-post-type.php';

endif;

if( function_exists('acf_add_options_page') ) {
 
   	acf_add_options_page( array( 
		'page_title' 	=> 'Review Setting',
		'parent'     => 'edit.php?post_type=testimonials_type',
		'capability'	=> 'edit_theme_options'
	));

}
?>