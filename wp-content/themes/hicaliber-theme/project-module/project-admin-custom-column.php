<?php

function project_add_acf_columns ( $columns ) {
     return array_merge ( $columns, array ( 
      'thumbnail' => __ ( '<span class="dashicons dashicons-format-image"></span>' ),
      'featured' => __ ( '<span class="dashicons dashicons-star-filled"></span>' ),
    ) );
  }
  add_filter ( 'manage_project_posts_columns', 'project_add_acf_columns' );

function projects_custom_column ( $column, $post_id ) {
    $h = new PROJECT_VIEW();
    switch ( $column ) {
      case 'thumbnail':
        $img = get_the_post_thumbnail_url( $post_id );
        if( $img ){
          echo '<img src="'.$img.'" width="40px" height="40px"/>';
        }
        break;
      case 'featured':
        if( get_post_meta( $post_id, 'hic_featured_post' , true ) ){
          echo '<span style="color: #0073aa;" class="dashicons dashicons-star-filled"></span>';
        } else {
          echo '<span style="color: #0073aa;" class="dashicons dashicons-star-empty"></span>';
        }
        break;
    }
  }


add_action ( 'manage_project_posts_custom_column', 'projects_custom_column', 10, 2 );


function project_col_order_wp_list( $columns ) {
    
   $new = array();
    
    $custom_order = array( 'cb', 'thumbnail', 'title', 'featured', 'taxonomy-project_cat', 'taxonomy-project_tag',  'date' );

  foreach ($custom_order as $colname){
    $new[$colname] = $columns[$colname];    
  }
    
  return $new;

}

add_filter( 'manage_edit-project_columns', 'project_col_order_wp_list' );