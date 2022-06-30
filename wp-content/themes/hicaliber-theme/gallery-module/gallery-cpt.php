<?php
function hi_gallery_cpt() { 

	// creating (registering) the custom type 
	register_post_type( 'gallery', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post typepro
		array('labels' => array(
			'name' => __('Gallery', 'hicaliber-theme'), /* This is the Title of the Group */
			'singular_name' => __('Gallery', 'hicaliber-theme'), /* This is the individual type */
			'all_items' => __('All Gallery', 'hicaliber-theme'), /* the all items menu item */
			'add_new' => __('Add New Gallery', 'hicaliber-theme'), /* The add new menu item */
			'add_new_item' => __('Add New Gallery', 'hicaliber-theme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'hicaliber-theme' ), /* Edit Dialog */
			'edit_item' => __('Edit Gallery', 'hicaliber-theme'), /* Edit Display Title */
			'new_item' => __('New Gallery', 'hicaliber-theme'), /* New Display Title */
			'view_item' => __('View Gallery', 'hicaliber-theme'), /* View Display Title */
			'search_items' => __('Search Gallery', 'hicaliber-theme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'hicaliber-theme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'hicaliber-theme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the gallery custom post type', 'hicaliber-theme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-images-alt2', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'gallery', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => false, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail',  'revisions')
	 	) /* end of options */
	); /* end of register post type */
	
} 

	// adding the function to the Wordpress init
add_action( 'init', 'hi_gallery_cpt');


	// now let's add custom categories (these act like categories)
    register_taxonomy( 'gallery_cat', 
    	array('gallery'), /* if you change the name of register_post_type( 'product', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Gallery Categories', 'hicaliber-theme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Gallery Category', 'hicaliber-theme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Gallery Categories', 'hicaliber-theme' ), /* search title for taxomony */
    			'all_items' => __( 'All Gallery Categories', 'hicaliber-theme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Gallery Category', 'hicaliber-theme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Gallery Category:', 'hicaliber-theme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Gallery Category', 'hicaliber-theme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Gallery Category', 'hicaliber-theme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Gallery Category', 'hicaliber-theme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Gallery Category', 'hicaliber-theme' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true, 
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'gallery-category' ),
    	)
    );   