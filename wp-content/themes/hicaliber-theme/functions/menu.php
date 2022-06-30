<?php
// Register menus

$reg_menu = GS_COMMON::resgistered_menu();

register_nav_menus(
	$reg_menu
);

// The Top Menu
function joints_top_nav() {
	wp_nav_menu(array(
		'container' => false,                           // Remove nav container
        'menu_class' => 'vertical medium-horizontal menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown" data-alignment="left">%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Topbar_Menu_Walker()
	));
}

// The Top Menu
function joints_location_menu() {
	wp_nav_menu(array(
		'container' => false,                           // Remove nav container
        'menu_class' => 'vertical medium-horizontal menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown" data-alignment="left">%3$s</ul>',
        'theme_location' => 'location-menu',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Topbar_Menu_Walker()
	));
}

// The Top Menu
function custom_joints_top_nav( $menu_selected ) {
	wp_nav_menu(array(
	   'container' => false,                                    // Remove nav container
	   'menu_class' => 'vertical medium-horizontal menu',       // Adding custom nav class
	   'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
	   'theme_location' => 'custom-menu',        		        // Where it's located in the theme
	   'depth' => 5,                                           // Limit the depth of the nav
	   'fallback_cb' => false,                                 // Fallback function (see below)
	   'walker' => new Topbar_Menu_Walker()
   ));
   
} 

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"menu\">\n";
	}
}

// The Off Canvas Menu
function joints_off_canvas_nav() {
	wp_nav_menu(array(
		'container' => false,                           // Remove nav container
        'menu_class' => 'vertical menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
        'theme_location' => 'mobile-menu',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Off_Canvas_Menu_Walker()
	));
}

class Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"vertical menu\">\n";
	}
}

// The Footer Menu
function joints_footer_links() {
	wp_nav_menu(array(
		'container' => 'false',                         // Remove nav container
    	'menu' => __( 'Footer 1', 'jointswp' ),   	// Nav name
    	'menu_class' => 'menu vertical',      					// Adding custom nav class
    	'theme_location' => 'footer-links',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
    	'fallback_cb' => ''  							// Fallback function
	));
} /* End Footer Menu */

// The Footer Menu
function joints_footer_links_2() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        'menu' => __( 'Footer 2', 'jointswp' ),     // Nav name
        'menu_class' => 'menu vertical',                        // Adding custom nav class
        'theme_location' => 'footer-links-2',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// The Footer Menu
function joints_footer_links_3() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        'menu' => __( 'Footer 3', 'jointswp' ),     // Nav name
        'menu_class' => 'menu vertical',                        // Adding custom nav class
        'theme_location' => 'footer-links-3',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// The Footer Menu
function joints_footer_links_4() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        'menu' => __( 'Footer 4', 'jointswp' ),     // Nav name
        'menu_class' => 'menu vertical',                        // Adding custom nav class
        'theme_location' => 'footer-links-4',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// The Footer Menu
function joints_top_menu() {
    wp_nav_menu(array(
        'container' => 'false',                         // Remove nav container
        'menu' => __( 'Top Menu', 'jointswp' ),     // Nav name
        'menu_class' => 'menu horizontal top-menu',                        // Adding custom nav class
        'theme_location' => 'top-menu',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
        'fallback_cb' => ''                             // Fallback function
    ));
} /* End Footer Menu */

// Header Fallback Menu
function joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home'		=> true,
		'menu_class'	=> '',		// Adding custom nav class
		'include'		=> '',
		'exclude'		=> '',
		'echo'			=> true,
		'link_before'	=> '',		// Before each link
		'link_after'	=> ''		// After each link
	));
}

// Footer Fallback Menu
function joints_footer_links_fallback() {
	/* You can put a default here if you like */
}

// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
	if ( $item->current == 1 || $item->current_item_ancestor == true ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );