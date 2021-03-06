<?php

// let's create the function for the custom type
function testimonials_posts() { 

	$exclude_from_site = get_field('testi_exclude_from_search', 'options');
	$custom_slug = get_field('testi_slug', 'options');
	$slug = ($custom_slug) ? $custom_slug : 'testimonial';


	$publicity = FALSE;
    
    if($exclude_from_site) {
        $publicity = TRUE;
    }

	// creating (registering) the custom type 
	register_post_type( 'testimonials_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Reviews', 'jointswp'), /* This is the Title of the Group */
			'singular_name' => __('Review', 'jointswp'), /* This is the individual type */
			'all_items' => __('All Reviews', 'jointswp'), /* the all items menu item */
			'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
			'add_new_item' => __('Add New Review', 'jointswp'), /* Add New Display Title */
			'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
			'edit_item' => __('Edit Review', 'jointswp'), /* Edit Display Title */
			'new_item' => __('New Review', 'jointswp'), /* New Display Title */
			'view_item' => __('View Review', 'jointswp'), /* View Display Title */
			'search_items' => __('Search Review', 'jointswp'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the testimonial custom post type', 'jointswp' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => $publicity,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-format-quote', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => $slug, 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => false, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'testimonials_posts');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( 'testimonials_cat', 
    	array('testimonials_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Categories', 'jointswp' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Category', 'jointswp' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Categories', 'jointswp' ), /* search title for taxomony */
    			'all_items' => __( 'All Categories', 'jointswp' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Category', 'jointswp' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Category:', 'jointswp' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Category', 'jointswp' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Category', 'jointswp' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Category', 'jointswp' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Category Name', 'jointswp' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true, 
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'custom-slug' ),
    	)
    );   