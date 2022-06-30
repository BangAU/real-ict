<?php
function flooring_projects() { 
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Projects', 'jointswp'), /* This is the Title of the Group */
			'singular_name' => __('Project', 'jointswp'), /* This is the individual type */
			'all_items' => __('All Projects', 'jointswp'), /* the all items menu item */
			'add_new' => __('Add New Project', 'jointswp'), /* The add new menu item */
			'add_new_item' => __('Add New Project', 'jointswp'), /* Add New Display Title */
			'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
			'edit_item' => __('Edit Projects', 'jointswp'), /* Edit Display Title */
			'new_item' => __('New Project', 'jointswp'), /* New Display Title */
			'view_item' => __('View Project', 'jointswp'), /* View Display Title */
			'search_items' => __('Search Project', 'jointswp'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example custom post type', 'jointswp' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-feedback', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => false, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'excerpt')
	 	) /* end of options */
	); /* end of register post type */
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'flooring_projects');
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( 'project_cat', 
    	array('project'), /* if you change the name of register_post_type( 'project', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Project Categories', 'jointswp' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Project Category', 'jointswp' ), /* single taxonomy name */
    			'search_items' =>  __( 'Project Categories', 'jointswp' ), /* search title for taxomony */
    			'all_items' => __( 'All Project Categories', 'jointswp' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Project Category', 'jointswp' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Project Category:', 'jointswp' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Project Category', 'jointswp' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Project Category', 'jointswp' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Project Category', 'jointswp' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Project Category', 'jointswp' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true, 
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'projects' ),
    	)
    );   
    
    register_taxonomy( 'project_tag', 
    	array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => false,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Project Tags', 'jointswp' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Project Tag', 'jointswp' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Project Tags', 'jointswp' ), /* search title for taxomony */
    			'all_items' => __( 'All Project Tags', 'jointswp' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Project Tag', 'jointswp' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Project Tag:', 'jointswp' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Project Tag', 'jointswp' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Project Tag', 'jointswp' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Project Tag', 'jointswp' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Project Tag Name', 'jointswp' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    	)
	); 