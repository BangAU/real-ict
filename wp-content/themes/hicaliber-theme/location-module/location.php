<?php
require_once( 'location-acf-settings.php' );
require_once( 'location-acf-details.php' );
require_once( 'location-acf-for-project-options.php' );
require_once( 'acf-location-category.php' );

define('LOCATION_SLUG', _get_field_value('ls_location_slug','options') ? _get_field_value('ls_location_slug','options') : 'location' );

require_once( 'temporary-location-query.php' );


require_once( 'location-cpt.php' );
require_once( 'location-api.php' );

if(_get_field_value('ls_location_post', 'options')){
    require_once( 'location-post.php' ); 
    require_once( 'location-page.php' ); 

    require_once( 'additional-details-user-location.php' );
    require_once( 'location-restriction.php' );
}

require_once( 'location-link-cpt.php' );

add_role('user-location', __(
	'User Location'),
	array(
		'read' => true,
	)
);

function get_location_base_url(){
    if(is_singular("location")) return get_permalink();
    elseif(is_singular("location_post")) {
        $location_id = _get_field_value("link_to_location");
        return get_permalink($location_id);
    } elseif(is_singular("location_page")) {
        $location_id = _get_field_value("link_to_location");
        return get_permalink($location_id);
    } else return false;
}

function get_region_id($region){
    $reqion_q = array();
    if($region){
        $args = [
            'post_type'      => 'location',
            'posts_per_page' => 1,
            'post_name__in'  => [$region],
            'fields'         => 'ids' 
        ];
        
        $reqion_q = get_posts( $args );
    }

    return count($reqion_q) == 1 ? $reqion_q[0] : "";
}

class LOCATION_MODULE {
    public static function add_option_settings() {
        if( function_exists('acf_add_options_page') ) {
           	acf_add_options_page( array( 
        		'page_title' 	=> 'Location Settings',
        		'parent'        => 'edit.php?post_type=location',
        		'capability'	=> 'edit_theme_options'
        	));
        }
    }

    public static function register_template() {
        add_filter( 'single_template', function( $single_template ) {
            global $post;
            if(get_page_template_slug($post->ID) == ""){
                if($post->post_type == 'location'){
                    $template = get_template_directory() . '/location-module/single-location.php';
                    if( is_readable( $template ) ) $single_template =  $template;
                } 
            }
            return $single_template;
        });
    }

    public static function sc_location( $atts ){
        $mapStyle = _get_field_value( 'map_design_code', 'options');
        $single_page = _get_field_value( 'ls_single_page', 'options');
        $helper_class = (!$single_page) ? ' single-page-disable' : '';
        
        if( is_singular('location') || is_singular('location_post') || is_singular('location_page') ){
            if(is_singular('location')){
    	        $location_id = get_the_ID();
    	    } elseif(is_singular('location_post') || is_singular('location_page')) {
    	        $location_id = _get_field_value('link_to_location');
    	    }
    	    
    	    $location_layout = _get_field_value('design_layout', $location_id); 
    	    
    	    if($location_layout == "layout-2"){
    	        $mapStyle = _get_field_value( 'map_design_code_2', 'options');
    	    }
        }
        
        $param = [];
        
        $a = shortcode_atts( [
            'category' => '',
            'ids'       => ''
        ], $atts );
       
        $isSingleLocation = is_singular('location') ? 'true' : 'false';
        
        if( $a['category'] ) {
            $param[] = "data-location-category='{$a['category']}'";
        }
        
        if( $a['ids'] ) {
            $param[] = "data-locations='{$a['ids']}'";
        }
        
        $param = implode(" ", $param );
        $preview_layout = _get_field_value('info_window_layout', 'options');

        ob_start();
        ?>
            <div id="htwMap" <?php echo $param; ?> class="location-map <?php echo $preview_layout; ?><?php echo $helper_class; ?>" data-map-single="<?php echo $isSingleLocation; ?>" data-map-style='<?php echo $mapStyle ? preg_replace('/\s/', '', $mapStyle) : false; ?>'></div>
        <?php
        return ob_get_clean();
    }
    public function __construct() {
        add_shortcode('location_map' , [ $this, 'sc_location' ] );
        self::add_option_settings();
        self::register_template();
    }
    
}

new LOCATION_MODULE();



