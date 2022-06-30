<?php
// Calling your own login css so you can style it
function joints_login_css() {
	wp_enqueue_style( 'joints_login_css', get_template_directory_uri() . '/assets/styles/login.css', false );
	wp_enqueue_style( 'custom_css', get_template_directory_uri() . '/assets/styles/login-custom.css', false );
}

// changing the logo link from wordpress.org to your site
function joints_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function joints_login_title() { return get_option('blogname'); }

$login_settings = get_field('opt_login_page', 'options');

function add_blog_id_to_login_page( $classes ) {
    
    
        $login_settings = get_field('opt_login_page', 'options');
        
        if($login_settings) {
            $classes[] = $login_settings['theme'];
            $classes[] = $login_settings['theme_colour'];
        }
    return $classes;
}



function hic_login_add_html_content() {
    $login_settings = get_field('opt_login_page', 'options');
    echo '<div class="login-disclaimer"><a href="https://www.hicaliber.com.au" target="_blank">Developed by Hicaliber</div>';
}


// calling it only on the login page
add_action( 'login_enqueue_scripts', 'joints_login_css', 10 );
add_filter('login_headerurl', 'joints_login_url');
add_filter('login_headertext', 'joints_login_title');
add_filter( 'login_body_class', 'add_blog_id_to_login_page' );


    add_action( 'login_form', 'hic_login_add_html_content' );    
