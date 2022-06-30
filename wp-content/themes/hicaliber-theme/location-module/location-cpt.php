<?php
function hep_location_cpt() { 
	
	$sp_enabled = get_field('ls_single_page', 'options');
	if($sp_enabled === NULL){
		$sp_enabled = true;
	}

	$franchisee_enabled = _get_field_value( 'ls_location_post', 'options') ? _get_field_value( 'ls_location_post', 'options') : false;
	$final_location_slug = $franchisee_enabled ? LOCATION_SLUG . '/%location_country%' : LOCATION_SLUG;

	$user = wp_get_current_user();

    if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		if( in_array( 'user-location' , $user->roles ) ) {
			$location_label = "Location Details";
		} else {
			$location_label = "Locations";
		}
	} else {
		$location_label = "Locations";
	}

	// creating (registering) the custom type 
	register_post_type( 'location', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post typepro
		array_merge(
			array(
				'labels' => array(
					'name' => __($location_label, 'jointswp'), /* This is the Title of the Group */
					'singular_name' => __('Location', 'jointswp'), /* This is the individual type */
					'all_items' => __('All Locations', 'jointswp'), /* the all items menu item */
					'add_new' => __('Add New Location', 'jointswp'), /* The add new menu item */
					'add_new_item' => __('Add New Location', 'jointswp'), /* Add New Display Title */
					'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
					'edit_item' => __('Edit Location', 'jointswp'), /* Edit Display Title */
					'new_item' => __('New Location', 'jointswp'), /* New Display Title */
					'view_item' => __('View Location', 'jointswp'), /* View Display Title */
					'search_items' => __('Search Location', 'jointswp'), /* Search Custom Type Title */ 
					'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */ 
					'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
					'parent_item_colon' => ''
				), /* end of arrays */
				'description' => __( 'This is the example custom post type', 'jointswp' ), /* Custom Type Description */
				'public' => true,
				'publicly_queryable' => $sp_enabled,
				'exclude_from_search' => false,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
				'menu_icon' => 'dashicons-location-alt', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
				'rewrite'	=> array( 'slug' => $final_location_slug , 'with_front' => false ),
				'has_archive' => false,
				//'rewrite'	=> array( 'slug' => 'location', 'with_front' => false ), /* you can specify its url slug */
				// 'has_archive' => $sp_enabled ? 'location' : false, /* you can rename the slug here */
				'capability_type' => 'post',
				// 'map_meta_cap' => true,
				'hierarchical' => false,
				/* the next one is important, it tells what's enabled in the post editor */
				'supports' => array( 'title', 'editor', 'thumbnail',  'revisions', 'excerpt')
			),
			$franchisee_enabled ? array(
				'capability_type' => 'location',
				'capabilities' => array(
					'edit_post' => 'edit_location',
					'edit_posts' => 'edit_location',	
					'edit_others_posts' => 'edit_other_location',
					'read_post' => 'read_location',
					'read_private_posts' => 'read_private_location',
					// 'create_posts' => 'create_location',
				),
			) : array() /* end of options */
		)
	); /* end of register post type */
	
} 

	// adding the function to the Wordpress init
add_action( 'init', 'hep_location_cpt');


	// now let's add custom categories (these act like categories)
    register_taxonomy( 'location_cat', 
    	array('location'), /* if you change the name of register_post_type( 'product', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Location Categories', 'jointswp' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Location Category', 'jointswp' ), /* single taxonomy name */
    			'search_items' =>  __( 'Location Categories', 'jointswp' ), /* search title for taxomony */
    			'all_items' => __( 'All Location Categories', 'jointswp' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Location Category', 'jointswp' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Location Category:', 'jointswp' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Location Category', 'jointswp' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Location Category', 'jointswp' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Location Category', 'jointswp' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Location Category', 'jointswp' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true, 
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( ),
    	)
    );   

      register_taxonomy( 'location_tag', 
    	array('location'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Location Tags', 'jointswp' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Location Tag', 'jointswp' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Location Tags', 'jointswp' ), /* search title for taxomony */
    			'all_items' => __( 'All Location Tags', 'jointswp' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Location Tag', 'jointswp' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Location Tag:', 'jointswp' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Location Tag', 'jointswp' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Location Tag', 'jointswp' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Location Tag', 'jointswp' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Location Tag Name', 'jointswp' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); 
