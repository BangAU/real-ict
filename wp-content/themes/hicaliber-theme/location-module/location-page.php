<?php

if( _get_field_value( 'ls_location_post', 'options') ):
    require_once( 'location-page-acf-settings.php' );
    
    define('LOCATION_PAGE_SLUG', _get_field_value('location_page_slug','options') ? _get_field_value('location_page_slug','options') : 'location_page' );

    require_once( 'location-page-cpt.php' );

    class LOCATION_PAGE_MODULE {
        public static function add_option_settings() {
            if( function_exists('acf_add_options_page') ) {
                   acf_add_options_page( array( 
                    'page_title' 	=> 'Location Page Settings',
                    'parent'        => 'edit.php?post_type=location_page',
                    'capability'	=> 'edit_theme_options'
                ));
            }
        }

        public static function register_template() {
            add_filter( 'single_template', function( $single_template ) {
                global $post;
                if(get_page_template_slug($post->ID) == ""){
                    if($post->post_type == 'location_page'){
                        $template = get_template_directory() . '/location-module/single-location-page.php';
                        if( is_readable( $template ) ) $single_template =  $template;
                    } 
                }
                return $single_template;
            });

        }
    
        public function __construct() {
            self::add_option_settings();
            self::register_template();
        }
        
    }
    
    new LOCATION_PAGE_MODULE();
endif;