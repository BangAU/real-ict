<?php

add_action( 'wp_enqueue_scripts', 'add_child_theme_stylesheets', PHP_INT_MAX );
function add_child_theme_stylesheets() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );  	 	
 	wp_enqueue_style( 'hicaliber-child-theme', get_stylesheet_directory_uri() . '/assets/css/hicaliber-child-theme.css' );
 	wp_enqueue_script( 'hic-custom-script',  get_stylesheet_directory_uri() . '/assets/js/custom-script.js', array( 'jquery' ), '1.0', true );
}


require_once( get_template_directory() . '/page-content-builder/assets/functions/models/hcPCBContent.php');
require_once( get_stylesheet_directory() . '/page-content-builder/assets/functions/models/hcPCBTestimonial.php');


require get_stylesheet_directory() . '/inc/module-register.php';
require get_stylesheet_directory() . '/inc/custom-block-categories.php';
require get_stylesheet_directory() . '/inc/module-restriction.php';