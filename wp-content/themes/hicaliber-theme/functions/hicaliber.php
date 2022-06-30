<?php
if ( !defined( 'ASSETS' ) ) define( 'ASSETS', get_template_directory_uri() . '/assets/' );
if ( !defined( 'ASSETS_IMG' ) ) define( 'ASSETS_IMG', get_template_directory_uri() . '/assets/images/' );
if ( !defined( 'ASSETS_VENDOR' ) ) define( 'ASSETS_VENDOR', get_template_directory_uri() . '/vendor/' );

require_once 'acf_codes.php';

// scripts

function hicaliber_site_scripts() {
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way  

    $theme = wp_get_theme();
    $theme_version = $theme->version;  
        
    if( _get_field_value('enable_full_screen_menu','options') ) {
      wp_enqueue_script( 'modernizr-js', get_template_directory_uri() . '/vendor/modernizr/js/_modernizr.custom.js', array(), $theme_version, true );
      wp_enqueue_style( 'fullscreen-menu-css', get_template_directory_uri() . '/vendor/fullscreen-menu/css/full-screen-menu.css', array(), $theme_version, 'all' );     
    }


  // Added scroll reveal
  if(get_field('opt_scroll_reveal', 'options')):
    wp_enqueue_script( 'scrollreveal-js', '//cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.7/scrollreveal.min.js', array(), $theme_version, true );
  endif;


  $params = array(
      'theme_assets_dir' => get_template_directory_uri() . '/assets/',
  );

  wp_localize_script('hical-map-js', 'mapscObj', $params); 
 
  $selected_theme_color = _get_field_value('site_colour_theme','options');

}

add_action('wp_enqueue_scripts', 'hicaliber_site_scripts', 1000);

//Set Image from assets/images/ directory
function hi_set_img($img_file_name) {
  return ASSETS_IMG. $img_file_name;
}
//Set background Image style
function hi_set_bg_img($img_file_name) {
  return 'style="background-image: url('.hi_set_img($img_file_name).')"';
}

function hi_set_bg_img_raw($img_file_name) {
  return 'style="background-image: url('.$img_file_name.')"';
}

function hi_set_acf_bg_img($field_name) {
  return 'style="background-image: url('._get_field_value($field_name).')"';
}

function hi_get_company_name() {
  return _get_field_value('aci_company_name', 'options');
}

function hi_set_company_name() {
  return hi_get_company_name();
}

function hi_get_unit() {
  return _get_field_value('aci_unit', 'options');
}

function hi_set_unit() {
  return hi_get_unit();
}

function hi_get_street_num() {
  return _get_field_value('aci_street_number', 'options');
}

function hi_set_street_num() {
  return hi_get_street_num();
}

function hi_get_postcode() {
  return _get_field_value('aci_postcode', 'options');
}

function hi_set_postcode() {
  return hi_get_postcode();
}

function hi_get_suburb() {
  return _get_field_value('aci_suburb', 'options');
}

function hi_set_suburb() {
  return hi_get_suburb();
}

function hi_get_state() {
  return _get_field_value('aci_state', 'options');
}

function hi_set_state() {
  return hi_get_state();
}

function hi_get_google_map() {
  return _get_field_value('aci_google_map', 'options');
}

function hi_set_google_map() {
  return hi_get_google_map();
}

function hi_get_primay_phone() {
  return _get_field_value('aci_primary_phone', 'options');
}

function hi_set_primary_phone() {
  return hi_get_primay_phone();
}

function hi_get_secondary_phone() {
  return _get_field_value('aci_secondary_phone', 'options');
}

function hi_set_secondary_phone() {
   return hi_get_secondary_phone();
}

function hi_get_social_fb() {
  return _get_field_value('social_facebook', 'options');
}

function hi_set_social_fb() {
   return hi_get_social_fb();
}

function hi_get_social_pinterest() {
  return _get_field_value('social_pinterest', 'options');
}

function hi_set_social_pinterest() {
   return hi_get_social_pinterest();
}

function hi_get_social_twitter() {
  return _get_field_value('social_twitter', 'options');
}

function hi_set_social_twitter() {
   return hi_get_social_twitter();
}

function hi_get_social_linkedin() {
  return _get_field_value('social_linkedin', 'options');
}

function hi_set_social_linkedin() {
   return hi_get_social_linkedin();
}

function hi_get_social_instagram() {
  return _get_field_value('social_instagram', 'options');
}

function hi_set_social_instagram() {
   return hi_get_social_instagram();
}

function hi_get_social_youtube() {
  return _get_field_value('social_youtube', 'options');
}

function hi_set_social_youtube() {
   return hi_get_social_youtube();
}

function hi_get_abn() {
  return _get_field_value('aci_abn', 'options');
}

function hi_set_abn() {
   return hi_get_abn();
}

function hi_get_acn() {
  return _get_field_value('aci_acn', 'options');
}

function hi_set_acn() {
   return hi_get_acn();
}


//Adding permission to Editor user to edit menus
$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );

// to be place in footer
function hical_fsm_display_menu() { 
  ?> 
  <div class="fullscreen-menu-overlay overlay-scale">
  <button type="button" class="overlay-close">&times;</button>
  <div class="v-align-container">
    <div class="t-cell">
      <nav>
        <?php 
          $custom_offcanvas_menu =  _get_field_value( 'page_menu_item' );  

          if( is_singular('location') && _get_field_value("ls_location_custom_design", "options")){
            if(_get_field_value('location_custom_menu')){
              $custom_offcanvas_menu = _get_field_value('location_menu_item');
            }
          } elseif( (is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")) {
            $parent_id = _get_field_value('link_to_location');
            if(_get_field_value('location_custom_menu', $parent_id)){
              $custom_offcanvas_menu = _get_field_value('location_menu_item', $parent_id);
            }
          } 

          if( $custom_offcanvas_menu ) {
            wp_nav_menu(array(
              'container' => false,                                               
              'menu_class' => 'vertical medium-horizontal menu',                  
              'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
              'theme_location' => $custom_offcanvas_menu,        		                    
              'depth' => 5,                                               
              'fallback_cb' => false, 
              'walker' => new Topbar_Menu_Walker()
            ));    
          } elseif( (is_singular('location') || is_singular('location_post') || is_singular('location_page') ) && has_nav_menu('location-menu') && _get_field_value("ls_location_custom_design", "options")) {
            joints_location_menu(); 
          } else {
            joints_off_canvas_nav();
          }
        ?>
      </nav>
    </div>
  </div>
  
  </div>  
<?php } 

?>