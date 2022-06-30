<?php
/* joints Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

*/


// let's create the function for the custom type
function services_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'services', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Services', 'jointswp'), /* This is the Title of the Group */
			'singular_name' => __('Services', 'jointswp'), /* This is the individual type */
			'all_items' => __('All Services', 'jointswp'), /* the all items menu item */
			'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
			'add_new_item' => __('Add New', 'jointswp'), /* Add New Display Title */
			'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
			'edit_item' => __('Edit Services', 'jointswp'), /* Edit Display Title */
			'new_item' => __('New', 'jointswp'), /* New Display Title */
			'view_item' => __('View Services', 'jointswp'), /* View Display Title */
			'search_items' => __('Search Services', 'jointswp'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the Services post type', 'jointswp' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 6, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-slides', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'services', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'services', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'services_post_type');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( 'services_cat', 
    	array('services'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
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
    