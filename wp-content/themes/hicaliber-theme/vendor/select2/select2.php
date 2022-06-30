<?php

function selec2_scripts() {
    
    
    $theme = wp_get_theme();
    $theme_version = $theme->version;  
    $template_url = get_template_directory_uri();
    
    wp_enqueue_style( 'j_selec_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', array(), $theme_version, 'all' );
    wp_enqueue_script( 'j_selec_2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array(), $theme_version, true );    

    
}

add_action('wp_enqueue_scripts', 'selec2_scripts', 500);