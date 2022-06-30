<?php
    
    // We need to refactor this project.php

	require_once 'featured-project-post.php';

	require_once 'project-post.php';
	
	//load acf
	require_once 'acf-project-settings.php';
	require_once 'acf-project.php';
	require_once 'acf-project-category.php';

	//require_once 'project-post.php';
	require_once 'project-helper.php';    
	require_once 'project-views.php';

	require_once 'project-admin-custom-column.php';

	function hex_set_project_type_template($single_template){
	    global $post;
	     if ($post->post_type == 'project') {
	         $single_template = get_template_directory() . '/project-module/single-project.php';
	     } 
	     return $single_template;
	}

	add_filter( 'taxonomy_template', function( $template ) {
	    $mytemplate = get_template_directory() . '/project-module/taxonomy-project_category.php';
	    if( is_tax( 'project_cat' ) && is_readable( $mytemplate ) )
	        $template =  $mytemplate;
	    return $template;
	});
	
	if( function_exists('acf_add_options_page') ) {
       	acf_add_options_page( array( 
    		'page_title' 	=> 'Project Settings',
    		'parent'     => 'edit.php?post_type=project',
    		'capability'	=> 'edit_theme_options'
    	));    
    }


	add_filter( 'single_template', 'hex_set_project_type_template' );