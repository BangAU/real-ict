<?php

class ALL_ASSETS {

    const assets = [

        // 'what-input-js' => [
        //   'js' => ['/vendor/what-input/what-input.min.js']
        // ],

        // 'motion-ui' => [
        //   'css'   => ['/vendor/motion-ui/dist/motion-ui.min.css']
        // ],

         // Slick Styles
        'slick' => [
          'js'  => ['/vendor/slick/slick.min.js'],
          'css' => ['/vendor/slick/slick.css', '/vendor/slick/slick-theme.css' ]
        ],

        // 'hic-pagination' => [
        //     'js' => ['/page-content-builder/assets/js/hic-pagination.js']
        // ],
        'jquery-simplePagination-js' => [
            'js'  => ['/page-content-builder/assets/js/jquery.simplePagination.js'],
           // 'css' => ['/page-content-builder/assets/css/simplePagination.css']
        ], 

        //Projects script
        'projects' => [
          'js'    => [  '/project-module/assets/js/project-module.js' ],        
        ],
        //Location script
        'location' => [         
          'js'    => ['/location-module/assets/js/locations.js']
        ],
    ];


    public static function assets(){

        global $wp_styles;
        $theme = wp_get_theme();
        $theme_version = $theme->version;  
        $template_uri = get_template_directory_uri();

        /**
         * THEME SETTINGS
         * */ 
        $parent_theme = _get_field_value('site_parent_theme','options');
        if ($parent_theme == null) {
            $parent_theme = 'hic-tgs';
        } else {
            $parent_theme = _get_field_value('site_parent_theme','options');
        }        
        $main_theme = _get_field_value('g_site_main_theme', 'options');
        $atrealty_theme = _get_field_value('hic_aet_theme', 'options');

        $assets  = [];
        $assets = apply_filters("hicaliber_assets", self::assets);
        
          /** Check Location and Projects if Enable **/
        $elements = get_field("sites_elements", "options") ?? array();
        //remove asset if module is disabled
        if(is_array($assets) && sizeof($assets) > 0):
            foreach($assets as $key => $asset):
                if($key == "projects" && !in_array($key, $elements) ):
                    unset($assets[$key]);
                endif;
                if($key == "location" && !in_array($key, $elements) ):
                    unset($assets[$key]);
                endif;
            endforeach;
        endif;

        $params = array(
            'site_url'    => home_url(),
            'permalink'   => get_permalink(),
            'adminurl'    => admin_url(),
            'ajaxurl'     => admin_url('admin-ajax.php'),
        );

        if( _get_field_value( 'ls_location_post', 'options') ){
          $params['location_base_url'] = get_location_base_url();
        }

        if( _get_field_value('sites_elements','options') && in_array('location', _get_field_value('sites_elements','options')) ){
          /* MAP SETTINGS */
          $map_default_marker = _get_field_value('map_default_marker', 'options');
          $map_selected_marker = _get_field_value('map_selected_marker', 'options');

          $params['pinmapDefault'] = $map_default_marker ? $map_default_marker : $template_uri.'/assets/images/pin-map-default.png';
          $params['pinmapSelected'] = $map_selected_marker ? $map_selected_marker : $template_uri.'/assets/images/pin-map-selected.png';
          $params['mapCenterLat'] = _get_field_value('map_center_lat', 'options');
          $params['mapCenterLng'] = _get_field_value('map_center_lng', 'options');
          $params['mapZoom'] = _get_field_value('map_zoom', 'options');
          $params['previewLayout'] = _get_field_value('info_window_layout', 'options');
          $params['previewContent'] = _get_field_value('preview_content_to_display', 'options');
        }

        if( is_element_exists('products') && _get_field_value('pgs_save_favourites_feature', 'options') ){
          $params['wishlistNoSaveMsg'] = _get_field_value('empty_wishlist_notification', 'options');
          $params['wishlistButton'] = _get_field_value('pgs_action_btn_save', 'options');
          $params['wishlistMultiEnquireBtn'] = _get_field_value('pgs_pgs_multi_enquire_btn', 'options');
          $params['wishlistListingLayout'] = _get_field_value('pgs_wl_listing_layout', 'options');
          $params['wishlistListingContent'] = _get_field_value('pgs_wl_listing_content', 'options');
        }
        
      if( sizeof( $assets ) > 0 ) {
        foreach( $assets as $key => $asset ) {
            if( isset( $asset['js'] ) ) {
              $i_js = 1;
              foreach( $asset['js'] as $js ) {
                wp_enqueue_script( $key . "-js-".$i_js , $template_uri . $js , ['jquery'], $theme_version, true );
                $i_js++;
              }
            }
            if( isset( $asset['css'] ) ) {
              $i_css = 1;
              foreach( $asset['css'] as $css ) {
                wp_enqueue_style( $key.'-css-'.$i_css, $template_uri . $css, array(), $theme_version, 'all' );
                $i_css++;
              }
            }
        }
      }

        wp_localize_script('site-js', 'hep', $params);
        
        if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script( 'comment-reply' );    
        }
    }

    function __construct() {
        add_action('wp_enqueue_scripts', [ $this,  'assets' ], 999);
    }


}

new ALL_ASSETS();