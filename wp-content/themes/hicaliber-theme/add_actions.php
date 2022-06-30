<?php

function insert_fb_in_head() {
    global $post;
    if ( !is_singular()) //if it is not a post or a page
        return;
        echo '<meta property="fb:admins" content="YOUR USER ID"/>';
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="AET Real Estate"/>';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        echo '<meta property="og:image" content="' . _get_field_value('property_gallery')[0]['sizes']['medium'] . '"/>';
    }
    else{
        //$thumbnail_src = getTheFirstImage();
        echo '<meta property="og:image" content="' . _get_field_value('property_gallery')[0]['sizes']['medium'] . '"/>';
    }
    echo "";
}

// add_action( 'wp_head', 'insert_fb_in_head', 5 );