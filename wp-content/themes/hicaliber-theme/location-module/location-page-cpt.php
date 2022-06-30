<?php
function hep_location_page_cpt() { 
	
	$sp_enabled = true;

	// creating (registering) the custom type 
	register_post_type( 'location_page', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post typepro
		array('labels' => array(
			'name' => __('Location Pages', 'jointswp'), /* This is the Title of the Group */
			'singular_name' => __('Location Page', 'jointswp'), /* This is the individual type */
			'all_items' => __('All Location Pages', 'jointswp'), /* the all items menu item */
			'add_new' => __('Add New Location Page', 'jointswp'), /* The add new menu item */
			'add_new_item' => __('Add New Location Page', 'jointswp'), /* Add New Display Title */
			'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
			'edit_item' => __('Edit Location Page', 'jointswp'), /* Edit Display Title */
			'new_item' => __('New Location Page', 'jointswp'), /* New Display Title */
			'view_item' => __('View Location Page', 'jointswp'), /* View Display Title */
			'search_items' => __('Search Location Page', 'jointswp'), /* Search Custom Type Title */ 
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
			'menu_icon' => 'dashicons-admin-page', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			//'rewrite'	=> array( 'slug' => 'location_page', 'with_front' => false ), /* you can specify its url slug */
			'rewrite'	=> array(  'slug' => LOCATION_PAGE_SLUG . '/%location_page_country%/%location_page_region%',  "with_front" => false ), 
			'has_archive' => false,
			'capability_type' => 'location_page',
			'capabilities' => array(
				'edit_post' => 'edit_location_page',
				'edit_posts' => 'edit_location_page',
				'edit_others_posts' => 'edit_other_location_page',
				'publish_posts' => 'publish_location_page',
				'read_post' => 'read_location_page',
				'read_private_posts' => 'read_private_location_page',
				'delete_post' => 'delete_location_page'
			),
			'hierarchical' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail',  'revisions', 'excerpt')
	 	) /* end of options */
	); /* end of register post type */
	
} 


class ADMIN_WP_ADMIN_COLUMN_LOCATION_PAGE {

    /****************************
     * Adding columns
     ****************************/

    function add_acf_columns ( $columns ) {
        return array_merge ( $columns, array ( 
            'location'               => __ ( 'Location' ),
        ) );
    }

    
    /****************************
     * Set Value
     ****************************/

    function custom_column ( $column, $post_id ) {
        $property_images = "";
        $floor_plan = "";
        switch ( $column ) {
            case 'location':
                $location_id = get_post_meta( $post_id, 'link_to_location' , true );
                echo get_the_title( $location_id );
                break; 
        }        
    }

    /****************************
     * Re Order Columns
     ****************************/

    function col_order_wp_list( $columns ) {
        $new = array();
        $custom_order = array( 'cb', 'title', 'location' , 'date' );
        foreach ($custom_order as $colname){
            $new[$colname] = $columns[$colname];
        }
        return $new;
    }

    public function __construct() {
        $post_type = "location_page";
        add_action ('manage_'.$post_type.'_posts_custom_column', [$this, 'custom_column' ], 10, 2 );
        add_filter('manage_edit-'.$post_type.'_columns', [$this, 'col_order_wp_list'] );
        add_filter ('manage_'.$post_type.'_posts_columns', [$this, 'add_acf_columns'] );
    }

}

new ADMIN_WP_ADMIN_COLUMN_LOCATION_PAGE();

// adding the function to the Wordpress init
add_action( 'init', 'hep_location_page_cpt'); 

