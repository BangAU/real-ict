<?php
if( _get_field_value( 'ls_location_post', 'options') ):
    require_once( 'location-post-acf-settings.php' );

    define('LOCATION_POST_SLUG', _get_field_value('location_post_slug','options') ? _get_field_value('location_post_slug','options') : 'location_post' );
    
    require_once( 'location-post-cpt.php' );

    class LOCATION_POST_MODULE {
        public static function add_option_settings() {
            if( function_exists('acf_add_options_page') ) {
                   acf_add_options_page( array( 
                    'page_title' 	=> 'Location Post Settings',
                    'parent'        => 'edit.php?post_type=location_post',
                    'capability'	=> 'edit_theme_options'
                ));
            }
        }
    
        public static function register_template() {
            add_filter( 'single_template', function( $single_template ) {
                global $post;
                if(get_page_template_slug($post->ID) == ""){
                    if($post->post_type == 'location_post'){
                        $template = get_template_directory() . '/location-module/single-location-post.php';
                        if( is_readable( $template ) ) $single_template =  $template;
                    } 
                }
                return $single_template;
            });

        }

        public static function create_rencent_posts_hero_sc(){
            ob_start();
                get_template_part('location-module/content', 'location-post-archive-hero'); 
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        public static function create_rencent_posts_sc($atts){
            extract(shortcode_atts(
                array(
                    'order'             => "date",
                    'orderby'           => "DESC",
                    'button_text'       => "Read more",

                    // Layout
                    'display'           => "content-only",
                    'layout'            => "grid",
                    'grid_layout'       => "default-grid-layout",
                    'autoplay'          => "false",
                    'per_row'           => "3",

                    // Design
                    'element_width'     => "default-width",
                    'alignment'         => "default-alignment",
                    'theme'             => "default-section",
                    'classes'           => "",
                    'background'        => "",
                    'id'                => "",

                    // Header
                    'heading'       => "",
                    'sub_heading'   => "",

                    // Content
                    "meta"          => "date,author,category",
                    "limit"         => "-1",
                    'filter'        => 'none',
                    'exclude_first' => "false"
                ), $atts
            ) );

            $per_row_class = array(
                "1" => "medium-12",
                "2" => "medium-6",
                "3" => "medium-4",
                "4" => "medium-6 large-3",
                "5" => "medium-4 large-2_4",
                "6" => "medium-4 large-2",
            );

            $limit = intval($limit);
            $autoplay = $autoplay == "true" ? true : false;
            $meta = $meta ? explode(",",$meta) : array();
            $exclude_first = $exclude_first == "true" ? true : false;
            $exclude_id = false;

            if(is_singular('location')){
                $location_id = get_the_ID();
            } elseif(is_singular('location_post') || is_singular('location_page')) {
                $location_id = _get_field_value('link_to_location');
            }

            if($exclude_first){
                $args = array(
                    'post_type'             => 'location_post',
                    'posts_per_page'        => 1,
                    'post_status'           => 'publish',
                    'order'                 => 'DESC',
                    'orderby'               => 'date',
                );
    
                if( $location_id ) {
                    $args['meta_key']   = 'link_to_location';
                    $args['meta_value'] = $location_id;
                } 
                
                $q = new WP_Query( $args );
    
                if($q->have_posts()): while( $q->have_posts() ) : $q->the_post(); 
                    $exclude_id = get_the_ID();
                endwhile; endif; wp_reset_postdata();
            }
            
            $elements = array();

            $elements['pe_posts_layout'] = array(
                "display"       => $display,
                "layout_type"   => $layout,
                "grid_layout"   => $grid_layout,
                "per_row"       => isset($per_row_class[$per_row]) ? $per_row_class[$per_row] : $per_row_class["3"],
                "slider_autoplay" => $autoplay,
            );

            $elements['pe_posts_design'] = array(
                "element_width"     => $element_width,
                "text_alignment"    => $alignment,
                "theme"             => $theme,
                "section_classes"   => $classes,
                "background_image"  => $background,
                "section_id"        => $id,
            );

            $elements['pe_posts_header'] = array(
                "peh_section_title" => $heading,
                "peh_sub_heading"   => $sub_heading,
            );
            
            $elements['pe_posts_content'] = array(
                "single_location_post_meta_options" => $meta,
                "quantity"                          => $limit,
                'search_filter'                     => $filter,
                'location'                          => $location_id,
                'exclude'                           => $exclude_id
            );

            $elements['pe_posts_footer'] = false; 

            ob_start();
                include( locate_template('page-content-builder/elements/content-location-post.php', false, false ) );
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    
        public function __construct() {
            self::add_option_settings();
            self::register_template();
            add_shortcode( 'recent_location_posts', array( $this, 'create_rencent_posts_sc' ) );
            add_shortcode( 'recent_location_posts_hero', array( $this, 'create_rencent_posts_hero_sc' ) );
        }
        
    }
    
    new LOCATION_POST_MODULE();
endif;