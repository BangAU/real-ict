<?php

/*******************************************
 * name = Folder Name or name of plugin
 ******************************************/

function hicaliber_vendor_libraries() {
    
	
	$uri_directory = get_template_directory_uri();
	
	if( is_child_theme() ) {
		//$uri_directory = get_stylesheet_directory_uri();
	}
    
    $theme = wp_get_theme();
    $theme_version = $theme->version;  
    $template_url = $uri_directory . '/vendor/';
		
    
    $vendors = array(

		array(
			'name'	=>	'jquery-validate',
			'js'	=>	'jquery.validate.min.js'
		),
		
		// array(
		//     'name'  => 'moment',		    
		//     'js'    => 'moment.min.js',
		// ),

		array(
		    'name'  => 'date-picker',
		    'css'   => 'air-datepicker.css',
		    'js'    => 'air-datepicker.js',
		),

		// array(
		//     'name'  => 'swiper',
		//     'css'   => 'swiper.min.css',
		//     'js'    => 'swiper.min.js',
		// ),
		
		array(
		    'name'  => 'isotope',
		    'js'    => 'isotope.pkgd.min.js',
		),

    );
   
	
	if( sizeOf( $vendors) > 0 ) {
	
		foreach( $vendors as $vendor ) {

			$name = $vendor['name'];
			$js_footer = true;

			if( isset( $vendor['js_footer'] )  && $vendor['js_footer'] == false ) {
				$js_footer = false;
			}

			if( isset( $vendor['js'] ) ) {
				// Include JS file
				wp_enqueue_script( $name.'_js', $template_url . $name  . "/" . $vendor['js'], array(), $theme_version, $js_footer );
			}

			// Include CSS file
			if( isset( $vendor['css'] ) ) {
				
				if( is_array( $vendor['css'] )  ){
					foreach( $vendor['css'] as $k => $css ) {
						wp_enqueue_style( $name.'_css_'.$k, $template_url . $name  . "/" . $css, array(), $theme_version,'all'  );	
					}
					
				} else {
					wp_enqueue_style( $name.'_css', $template_url . $name  . "/" . $vendor['css'], array(), $theme_version,'all'  );	
				}
				
			}

			// External Js
			if( isset( $vendor['external_js'] ) ) {
				wp_enqueue_script( $name.'_js', $vendor['external_js'], array(), $theme_version, true );
			}

			// External CSS file
			if( isset( $vendor['external_css'] ) ) {
				wp_enqueue_style( $name.'_css', $vendor['external_css'], array(), $theme_version,'all'  );           
			}

		}
	}
    
    
}


function hicaliber_admin_vendor_libraries() {
	
	$theme = wp_get_theme();
    $theme_version = $theme->version;  
    $template_url = get_template_directory_uri() . '/vendor/';
    
    $vendors = array(
		
		// array(
		// 	'name'	=> 'css-admin',
		// 	'css'	=> 'css-admin.css'
		// )
	
    );
   
	
	if( sizeOf( $vendors) > 0 ) {
	
		foreach( $vendors as $vendor ) {

			$name = $vendor['name'];


			if( isset( $vendor['js'] ) ) {
				// Include JS file
				wp_enqueue_script( $name.'_js', $template_url . $name  . "/" . $vendor['js'], array(), $theme_version, true );    
			}

			// Include CSS file
			if( isset( $vendor['css'] ) ) {
				wp_enqueue_style( $name.'_css', $template_url . $name  . "/" . $vendor['css'], array(), $theme_version,'all'  );           
			}

			// External Js
			if( isset( $vendor['external_js'] ) ) {                
				wp_enqueue_script( $name.'_js', $vendor['external_js'], array(), $theme_version, true );
			}

			// External CSS file
			if( isset( $vendor['external_css'] ) ) {
				wp_enqueue_style( $name.'_css', $vendor['external_css'], array(), $theme_version,'all'  );           
			}

		}
	}
	
}


// require_once( dirname( __FILE__ ) . '/hicaliber-post-type.php' );
// add_action( 'admin_head', 'hicaliber_wp_admin_head' );

add_action('wp_enqueue_scripts', 'hicaliber_vendor_libraries', 500);
add_action('admin_enqueue_scripts', 'hicaliber_admin_vendor_libraries', 500);