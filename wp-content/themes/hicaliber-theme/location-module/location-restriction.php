<?php

class Location_Restriction {
/*
add_role('user-location', __(
    'User Location'),
    array(
        'read' 	=> true,
    )
);
*/

public function __construct(){
    add_filter( 'post_type_link', [$this, 'cpp_user'], 10, 2 );
    add_action( 'save_post', [$this, 'save_post' ] , 10,3 );
    add_action( 'load-post.php', [$this, 'load_post_page'] );
    add_action( 'admin_init', [$this, 'user_location_role'] );
    add_action( 'pre_get_posts', [$this, 'filter_wp_admin_column'] );
    add_action( 'init', [$this, 'rewurl_9282223232'] );
    add_action( 'admin_head', [$this, 'location_admin_head']);
    add_action( "current_screen" , [$this, 'custom_view_count'], 20);
    
}

function custom_view_count( $current_screen ) {
    if ($current_screen->id === 'edit-location' || $current_screen->id === 'edit-location_post' || $current_screen->id === 'edit-location_page'){
        add_filter( "views_{$current_screen->id}", function( array $view ){

            

            $user = wp_get_current_user();
            $link = get_user_meta( $user->ID, 'user_location' , true );
            
            if( isset( $_REQUEST['post_type'] ) && $link  ) {

                $post_type = $_REQUEST['post_type'];

                if( $post_type == 'location' || $post_type == 'location_post' || $post_type == 'location_page' ) {
                    
                    global $wpdb;

                    if($post_type == 'location'){
                        $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' OR post_status = 'draft' OR post_status = 'pending') AND ID = '$link' AND post_type = '$post_type'");
                        $publish = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND ID = '$link' AND post_type = '$post_type' ");
                        $draft = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'draft' AND ID = '$link' AND post_type = '$post_type' ");
                        $pending = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'pending' AND ID = '$link' AND post_type = '$post_type' ");
                        $trash = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'trash' AND ID = '$link' AND post_type = '$post_type' ");
                    } /*elseif($post_type == 'location_post' || $post_type == 'location_page'){
                        $key = "link_to_location";
                        $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS posts INNER JOIN $wpdb->postmeta AS $key ON $key.post_id = posts.ID AND $key.meta_key = '$link' WHERE (posts.post_status = 'publish' OR posts.post_status = 'draft' OR posts.post_status = 'pending') AND posts.post_type = '$post_type'");
                        $publish = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS posts INNER JOIN $wpdb->postmeta AS $key ON $key.post_id = posts.ID AND $key.meta_key = '$link' WHERE posts.post_status = 'publish' AND posts.post_type = '$post_type' ");
                        $draft = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS posts INNER JOIN $wpdb->postmeta AS $key ON $key.post_id = posts.ID AND $key.meta_key = '$link' WHERE posts.post_status = 'draft' AND posts.post_type = '$post_type' ");
                        $pending = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS posts INNER JOIN $wpdb->postmeta AS $key ON $key.post_id = posts.ID AND $key.meta_key = '$link' WHERE posts.post_status = 'pending' AND posts.post_type = '$post_type' ");
                        $trash = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS posts INNER JOIN $wpdb->postmeta AS $key ON $key.post_id = posts.ID AND $key.meta_key = '$link' WHERE posts.post_status = 'trash' AND posts.post_type = '$post_type' ");
                    }*/

                    if(isset($view['all'])){
                        $view['all'] = preg_replace( '/\(.+\)/U', '('.$total.')', $view['all'] ); 
                    } 
                    
                    if(isset($view['publish'])){
                        $view['publish'] = preg_replace( '/\(.+\)/U', '('.$publish.')', $view['publish'] ); 
                    } 
                    
                    if(isset($view['draft'])){
                        $view['draft'] = preg_replace( '/\(.+\)/U', '('.$draft.')', $view['draft'] ); 
                    } 
                    
                    if(isset($view['pending'])){
                        $view['pending'] = preg_replace( '/\(.+\)/U', '('.$pending.')', $view['pending'] ); 
                    }

                    if(isset($view['trash'])){
                        $view['trash'] = preg_replace( '/\(.+\)/U', '('.$trash.')', $view['trash'] ); 
                    }
                }
                
            }

            return $view;
        } );
    }
}

public static function cpp_user( $permalink, $post ) {	
	if( is_wp_error( $post )  ) {
		return $permalink;
	}
	
    $link = ""; 
    
	if(  $post->post_type == "location_post" ) {
	     $r = get_post_meta( $post->ID , 'post_location_sub_region' , true );
         $c = get_post_meta( $post->ID , 'post_location_main_region' , true );
         $permalink = str_replace( '%location_post_country%/%location_post_region%', $c."/".$r, $permalink );
    }
    
    if(  $post->post_type == "location_page" ) {
        $r = get_post_meta( $post->ID , 'page_location_sub_region' , true );
        $c = get_post_meta( $post->ID , 'page_location_main_region' , true );
        $permalink = str_replace( '%location_page_country%/%location_page_region%', $c."/".$r, $permalink );
    }
	
    if( $post->post_type  ==  "location" ) {
        $r = get_post_meta( $post->ID , 'location_adress_country' , true );
        if( $r === "AU" ) {
            $r = sanitize_title($r);    
        } else {
            $r = "int";
        }
        
        $permalink = str_replace( '%location_country%', $r, $permalink );
    }
    	
    return $permalink;
}

public static function rewurl_9282223232(){
    add_rewrite_tag( '%location_post_country%' , '([^&]+)');
    add_rewrite_tag( '%location_post_region%' , '([^&]+)');
	add_rewrite_rule( 
		'^'.LOCATION_POST_SLUG.'/([^/]*)/([^/]*)/([^/]*)/?' , 
		'index.php?location_post=$matches[3]&location_post_country=$matches[2]&location_post_region=$matches[1]',
		"top"
    ) ;

    add_rewrite_tag( '%location_page_country%' , '([^&]+)');
    add_rewrite_tag( '%location_page_region%' , '([^&]+)');
    add_rewrite_rule( 
		'^'.LOCATION_PAGE_SLUG.'/([^/]*)/([^/]*)/([^/]*)/?' , 
		'index.php?location_page=$matches[3]&location_page_country=$matches[2]&location_page_region=$matches[1]',
		"top"
    ) ;

	add_rewrite_tag( '%location_country%' , '([^&]+)');
	add_rewrite_rule( 
		'^'.LOCATION_SLUG.'/([^/]*)/([^/]*)/?' , 
		'index.php?location=$matches[2]&location_country=$matches[1]',
		"top"
    ) ;

}

public static function user_location_role() {
    
    $admin_role = get_role( 'administrator' );

    $admin_role->add_cap( 'edit_location_post' ); 
    $admin_role->add_cap( 'read_location_post' ); 
    $admin_role->add_cap( 'delete_location_post' ); 
    $admin_role->add_cap( 'edit_other_location_post' ); 
    $admin_role->add_cap( 'publish_location_post' ); 
    $admin_role->add_cap( 'read_private_location_post' ); 
    
    $admin_role->add_cap( 'edit_location_page' ); 
    $admin_role->add_cap( 'read_location_page' ); 
    $admin_role->add_cap( 'delete_location_page' ); 
    $admin_role->add_cap( 'edit_other_location_page' ); 
    $admin_role->add_cap( 'publish_location_page' ); 
    $admin_role->add_cap( 'read_private_location_page' ); 

    $admin_role->add_cap( 'edit_location' ); 
    $admin_role->add_cap( 'read_location' ); 
    $admin_role->add_cap( 'delete_location' ); 
    $admin_role->add_cap( 'edit_other_location' ); 
    $admin_role->add_cap( 'publish_location' ); 
    $admin_role->add_cap( 'read_private_location' ); 

    $user_role = get_role( 'user-location' );

    $user_role->add_cap( 'edit_location_post' ); 
    $user_role->add_cap( 'read_location_post' ); 
    $user_role->add_cap( 'delete_location_post' ); 
    $user_role->add_cap( 'edit_other_location_post' ); 
    $user_role->add_cap( 'publish_location_post' ); 
    $user_role->add_cap( 'read_private_location_post' ); 

    $user_role->add_cap( 'edit_location_page' ); 
    $user_role->add_cap( 'read_location_page' ); 
    $user_role->add_cap( 'delete_location_page' ); 
    $user_role->add_cap( 'edit_other_location_page' ); 
    $user_role->add_cap( 'publish_location_page' ); 
    $user_role->add_cap( 'read_private_location_page' ); 

    $user_role->add_cap( 'edit_location' ); 
    $user_role->add_cap( 'read_location' );
    $user_role->add_cap( 'edit_other_location' );  
    $user_role->add_cap( 'read_private_location' );  

    $user_role->add_cap( 'unfiltered_html' ); 

    $user_role->add_cap( 'upload_files' );
    
}

public static function location_admin_head(  ) {
    $user = wp_get_current_user();

    if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( 'user-location' , $user->roles ) ) : ?>
            <style>
            #menu-media,
            #wp-admin-bar-new-location,
            #menu-posts-location .wp-submenu li:not(.wp-sub-menu-head):not(.wp-first-item),
            .wrap .wp-heading-inline+.page-title-action[href*="post-new.php?post_type=location"] {
                display: none;
            }
            </style>
        <?php
        endif;
    } else return;
}

public static function save_post( $post_id, $post, $update ) {
    if ( 'location_post' == $post->post_type || 'location_page' == $post->post_type ) {
        $role = "";
        $user = wp_get_current_user();
        $location = get_user_meta(  $user->ID , 'user_location', true );	
        if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
            if( in_array( 'user-location' , $user->roles ) && $location ) {
                if( $post ) {
                    $the_post = get_post( $location );
                    $post_data = json_encode( $the_post );
                    update_field( 'link_to_location' , $location , $post_id  );
                    if('location_page' == $post->post_type){
                        update_post_meta( $post_id , 'linked_page_location_data' , $post_data );
                    } else {
                        update_post_meta( $post_id , 'linked_post_location_data' , $post_data );
                    }
                    
                    $post_cat = get_the_terms( $the_post->ID, 'location_cat' );
                    $get_post_title = $the_post->post_name;
                    $parent_slug = '';
                    $sub_slug = '';
                    if( $post_cat ) {
                        foreach( $post_cat as $tax ) {
                            if( $tax->parent == 0 ) {
                                $parent_slug = $tax->slug;
                            } else {
                                $sub_slug = $tax->slug;
                            }
                        }
                        if('location_page' == $post->post_type){
                            update_post_meta( $post_id , 'page_location_cat' , $post_cat );
                            update_post_meta( $post_id , 'page_location_main_region' , $parent_slug );
                            update_post_meta( $post_id , 'page_location_sub_region' , $get_post_title );
                        } else {
                            update_post_meta( $post_id , 'post_location_cat' , $post_cat );
                            update_post_meta( $post_id , 'post_location_main_region' , $parent_slug );
                            update_post_meta( $post_id , 'post_location_sub_region' , $get_post_title );
                        }
                    }
                }
            } elseif( in_array( 'administrator' , $user->roles ) ) {
                
                $post_cat = get_post_meta( $post_id , 'link_to_location' , true  );
                $the_post = get_post( $post_cat );
                $post_cat = get_the_terms( $post_cat, 'location_cat' );
                
                if( $post_cat ) {
                        foreach( $post_cat as $tax ) {
                            if( $tax->parent == 0 ) {
                                $parent_slug = $tax->slug;
                            } else {
                                $sub_slug = $tax->slug;
                            }
                        }
                        if('location_page' == $post->post_type){
                            update_post_meta( $post_id , 'page_location_cat' , $the_post );
                            update_post_meta( $post_id , 'page_location_main_region' , $parent_slug );
                            update_post_meta( $post_id , 'page_location_sub_region' , $the_post->post_name );
                        } else {
                            update_post_meta( $post_id , 'post_location_cat' , $the_post );
                            update_post_meta( $post_id , 'post_location_main_region' , $parent_slug );
                            update_post_meta( $post_id , 'post_location_sub_region' , $the_post->post_name );
                        }
                    }
                
                // link_to_location-
                // update_post_meta( $post_id , 'post_location_main_region' , $s );
                // update_post_meta( $post_id , 'post_location_sub_region' , $get_post_title );
            }
            
            
        }
    } else {
        return;
    }
}

public static function load_post_page(){
    global $current_screen;
    global $posts;

    $user = wp_get_current_user();
    $link = get_user_meta( $user->ID, 'user_location' , true );
    $post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : "";


    if( is_admin() && ("location_post" == $current_screen->post_type || "location_page" == $current_screen->post_type ) && $post_id ) {
        if( get_post_meta( $post_id , 'link_to_location' , true ) != $link &&  !in_array('administrator' , $user->roles ) ) {
            $link = home_url('wp-admin/edit.php?post_type='.$current_screen->post_type);
            wp_die( "Sorry you don't access to view/edit this page <a href='".$link."'>Return to locations</a>");
        }
    } elseif( is_admin() && "location" == $current_screen->post_type && $post_id ) {
        if( $post_id != $link &&  !in_array('administrator' , $user->roles ) ) {
            $link = home_url('wp-admin/edit.php?post_type='.$current_screen->post_type);
            wp_die( "Sorry you don't access to view/edit this page <a href='".$link."'>Return to locations</a>");
        }
    }
}

public static function filter_wp_admin_column( $query ) {

    if ( ! is_admin() )
        return;
        $user = wp_get_current_user();
        $link = get_user_meta( $user->ID, 'user_location' , true );
        
        if( isset( $_REQUEST['post_type'] ) && $link  ) {
            if( $_REQUEST['post_type'] == "location_post" || $_REQUEST['post_type'] == "location_page" ) {
                $meta_query_args = array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'link_to_location',
                        'value'   => $link,
                    ),			
                );
                $query->set( 'meta_query', $meta_query_args );
            } elseif( $_REQUEST['post_type'] == "location" ) {
                $query->set( 'post__in', array($link) );
            }
            
        }

}



}

new Location_Restriction();