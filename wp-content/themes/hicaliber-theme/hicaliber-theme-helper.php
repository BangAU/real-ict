<?php

class hicaliber_theme_helpers {

    /********
     * Add Body Class
    ********/

    public static function add_body_classes($classes) {

        if( (is_singular('location') || is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")){
            $fixed_header = _get_field_value('ls_fix_header','options') == true ? "sticky-header" : "";
        } else {
            $fixed_header = _get_field_value('g_site_fix_header','options') == true ? "sticky-header" : "";
        }
        
        if( is_home() ) {
            $page_class = '';
            $id = get_option( 'page_for_posts' );
            $page_custom_css = _get_field_value('page_custom_css', $id);             
            $page_class .= $page_custom_css ? ' ' . $page_custom_css : '';
            $banner_display_option = _get_field_value('show_page_banner',$id);
            $classes[] = $page_class;           
            $classes[] = (!$banner_display_option) ? 'page-banner-hidden' : '';
        } else {
            $page_class = '';
            $page_custom_css = _get_field_value('page_custom_css');
            $page_class .= $page_custom_css ? ' ' . $page_custom_css : '';
            $banner_display_option = _get_field_value('show_page_banner');
            $classes[] = $page_class;
            
            if(is_singular('post')) {
                $banner_options = _get_field_value('post_single_banner_options','options');
                
                $single_post_banner = FALSE;
    
                if($banner_options && $banner_options['show_page_banner']) {
                    $single_post_banner = TRUE;
                }  
                
                if(($banner_options && !$banner_options['show_page_banner']) && $single_post_banner == FALSE) {
                    $classes[] = 'page-banner-hidden'; 
                }
                
                $categories = get_the_category(get_the_ID());
                
    
                    if(!empty($categories)) {
                        $arr = array();
                         foreach($categories as $category) {
                            $arr[] = $category->slug;
                        }
                    $classes[] = implode(' ', $arr);
                }
            
                
            } elseif(is_singular('gallery')) {
                $banner_options = get_field('gallery_single_page_banner', 'options');
                $show_page_banner = !empty($banner_options['show_page_banner']) ? $banner_options['show_page_banner'] : FALSE ;
                
                 $classes[] = (!$show_page_banner) ? 'page-banner-hidden' : ''; 
            } elseif(is_singular('property_type')) {
                $hero_layout_option = get_field('op_single_gallery_layout', 'options');
                $show_page_banner = $hero_layout_option == 'layout-4' ? true : false;
                
                 $classes[] = (!$show_page_banner) ? 'page-banner-hidden' : ''; 
            } elseif((is_singular('location') || is_singular('location_post') || is_singular('location_page')) && 
            _get_field_value("ls_location_post", "options")) {
                if(is_singular('location')) {
                    $locationlayout = get_field('design_layout');
                } elseif(is_singular('location_post') || is_singular('location_page')) {
                    $parent_id = _get_field_value('link_to_location');
                    $locationlayout = get_field('design_layout', $parent_id);
                } 

                 $classes[] = $locationlayout ? 'location-' . $locationlayout : 'location-layout-1'; 
            } else {
                
                if(is_category() || is_archive() ) { 
                    $banner_options = get_field('pc_banner_option', 'options');
                      if(is_tax('gallery_cat')) {
		                $banner_options = get_field('gallery_cat_banner', 'options');
                      }  
		            $banner_display_option =  isset($banner_options['show_page_banner']) ? $banner_options['show_page_banner'] : false;
                }
                    
               $classes[] = (!$banner_display_option) ? 'page-banner-hidden' : ''; 
            }
            
            
        }
        
        if ( is_page_template( 'template-cpt-archive.php' ) ) {
            $classes[] = 'cpt-archive';
        }

        $classes[] = $fixed_header; 
        
        $options_fields = [
            'site_parent_theme',
            'site_global_layout',
            'page_custom_css',            
            'g_site_width',
            'g_site_header_background_color',
            'site_footer_background_color',
        ];

        foreach( $options_fields as $ops ) {
            $classes[] = _get_field_value( $ops, 'options' );
        }

        if(_get_field_value('g_site_show_top_header','options')) {
            $top_header = 'with-top-header';
            $classes[] = $top_header;
        }

        $classes = array_filter($classes);
       
        return $classes;
    
    }
    
    public static function css_class_helper( $css = array()){
        $class="";
        $item_count = count( $css );
        $i = 1;

        foreach( $css as $c ){

            if( !empty($c)  ) {
                $class .= $c." ";
            }
            
            $i++;
        }
        return trim($class);
    }
    
    /********
    * Set Background image
    ********/
    
     public static function design_background_image( $img = false ) {
        
        $html = "";
        if( $img ) {
          $html = '<div class="bg-float bg-helper bg-image" style="background-image:url('.$img.')" ></div>';
        }
        
        return $html;
    }
    
    
    /********
    * CTA button
    ********/
    
     public static function section_button( $btn_element = array() ) {
        
        $html = "";
        
        if( $btn_element ) {
            $lbl = ($btn_element['title']) ? $btn_element['title'] : 'View More'; 
            
            $html .= '<div class="grid-container">';
            $html .= '<div class="grid-x grid-padding-x text-center"><div class="cell small-12">';
            $html .= '<a href="'.$btn_element['url'].'"';
            if($btn_element['target']) $html .= ' target="'.$btn_element['target'].'"';
            $html .= ' class="button uppercase">'.$lbl.'</a>';
            $html .= '</div></div>';
            $html .= '</div>';
            
            return $html;
        }
        

    }
    
    
    /********
    * Star Rating
    ********/
    
     public static function rating( $val = "" ) {
        
        $ratings = ["none-selected","one","two","three","four","five"];
        $html = "";
        $rated = "<i class='fas fa-star'></i>";

        foreach( $ratings as $i => $rating ) {
            
            if( $rating == $val ) {
                $rated = "<i class='far fa-star'></i>";        
            }
            
            if( $i < (count($ratings) -1) ) {
                $html .= $rated;    
            }
        }
        
        return "<div class='testimonial-rating'>".$html."</div>";
    }

    public static function hi_get_registered_sidebars( $name = '', $current_value = false ) {
        global $wp_registered_sidebars;
    
        if ( empty( $wp_registered_sidebars ) )
            return;
    
        return $wp_registered_sidebars;
    }
    
    
    public function __construct(){
        add_filter('acf/settings/remove_wp_meta_box', '__return_true');
        add_filter('body_class', array( $this, 'add_body_classes' ) );
    }

}

$hicaliber_theme_helpers = new hicaliber_theme_helpers;