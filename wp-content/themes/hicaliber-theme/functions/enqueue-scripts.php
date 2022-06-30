<?php
function site_scripts() {
    
    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    $wptheme = wp_get_theme();
    $theme_version = $wptheme->version;
    
    $theme = get_field('site_parent_theme', 'options');
        
    // Adding scripts file in the footer
    wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/scripts/scripts.js', array( 'jquery' ), filemtime(get_template_directory() . '/assets/scripts/js'), true );

     // Adding scripts file in the footer
    //wp_enqueue_script( 'hic-site-js', get_template_directory_uri() . '/assets/scripts/hic-scripts.js', array( 'jquery' ), '', true );
   
    // Register main stylesheet
    
    wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/styles/style.css', array(), filemtime(get_template_directory() . '/assets/styles/scss'), 'all' );


    // Fancybox
   wp_enqueue_script( 'fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array( 'jquery' ), $theme_version, true );
    wp_enqueue_style( 'fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', array(), $theme_version, 'all' );
    
    wp_enqueue_style( 'hicaliber-css', get_template_directory_uri() . '/assets/styles/hicaliber-base.css', array(), '' , '', 'all' );
    
    if( $theme == 'hbt' ) {
        wp_enqueue_style( 'business-style', get_template_directory_uri() . '/assets/styles/hicaliber-business-theme.css', array(), '', '', 'all' );    
    }
    if( $theme == 'hct' ) {
        wp_enqueue_style( 'creative-style', get_template_directory_uri() . '/assets/styles/hicaliber-creative-theme.css', array(), '', '', 'all' );    
    }
    if( $theme == 'hht' ) {
        wp_enqueue_style( 'hotel-style', get_template_directory_uri() . '/assets/styles/hicaliber-hotel-theme.css', array(), '', '', 'all' );    
    }
    if( $theme == 'hmt' ) {
        wp_enqueue_style( 'modern-style', get_template_directory_uri() . '/assets/styles/hicaliber-modern-theme.css', array(), '', '', 'all' );    
    }
    
    // Comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);