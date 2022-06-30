<?php
    
    function hpla_manager_post() { 
        
    $exclude_from_site = get_field('team_exclude_from_search', 'options');
    
    $publicity = TRUE;
    
    if($exclude_from_site) {
        $publicity = FALSE;
    }
        
	// creating (registering) the custom type 
	register_post_type( 'team', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Team', 'jointstheme'), /* This is the Title of the Group */
			'singular_name' => __('Team', 'jointstheme'), /* This is the individual type */
			'all_items' => __('All Member', 'jointstheme'), /* the all items menu item */
			'add_new' => __('Add New Member', 'jointstheme'), /* The add new menu item */
			'add_new_item' => __('Add New Member', 'jointstheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'jointstheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Member', 'jointstheme'), /* Edit Display Title */
			'new_item' => __('New Member', 'jointstheme'), /* New Display Title */
			'view_item' => __('View Member', 'jointstheme'), /* View Display Title */
			'search_items' => __('Search Members', 'jointstheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'jointstheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'jointstheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the Team custom post type', 'jointstheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => $publicity,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */		
			'menu_icon' => 'dashicons-groups', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'team-member', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => false, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */

}

function hpla_register_team_category(){
	register_taxonomy( 'team_cat', 
    	array('team'), /* if you change the name of register_post_type( 'project', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Team Categories', 'jointswp' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Team Category', 'jointswp' ), /* single taxonomy name */
    			'search_items' =>  __( 'Team Categories', 'jointswp' ), /* search title for taxomony */
    			'all_items' => __( 'All Team Categories', 'jointswp' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Team Category', 'jointswp' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Team Category:', 'jointswp' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Team Category', 'jointswp' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Team Category', 'jointswp' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Team Category', 'jointswp' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Team Category', 'jointswp' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true, 
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'teams' ),
    	)
    );
}
	add_action( 'init', 'hpla_manager_post', 10 );
	hpla_register_team_category();

?>