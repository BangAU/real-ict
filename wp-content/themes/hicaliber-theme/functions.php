<?php
/** 
 * For more info: https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */			
 
 
require_once( get_template_directory().'/settings.php' );
require_once( get_template_directory().'/page-content-builder/assets/functions/pcb.php' );
require_once( get_template_directory().'/vendor/hicaliber-vendor-libraries.php' );

// Load ACF field groups
//require_once( get_template_directory().'/acf-php-settings/featured-post.php' );
require_once( get_template_directory().'/acf-php-settings/post-option.php' );
require_once( get_template_directory().'/acf-php-settings/page-options.php' );
require_once( get_template_directory().'/acf-php-settings/page-content-builder.php' );
require_once( get_template_directory().'/acf-php-settings/page-content-builder-element.php' );
require_once( get_template_directory().'/acf-php-settings/cpt-page-builder-element.php' );
require_once( get_template_directory().'/acf-php-settings/page-content-builder-column.php' );
require_once( get_template_directory().'/acf-php-settings/page-element-layout.php' );
require_once( get_template_directory().'/acf-php-settings/page-element-header.php' );
require_once( get_template_directory().'/acf-php-settings/page-element-design.php' );
require_once( get_template_directory().'/acf-php-settings/page-element-button.php' );
require_once( get_template_directory().'/acf-php-settings/cpt-options.php' );
require_once( get_template_directory().'/acf-php-settings/testimonial-options.php' );
require_once( get_template_directory().'/acf-php-settings/ratings.php' );
require_once( get_template_directory().'/acf-php-settings/team-profile.php' );
require_once( get_template_directory().'/acf-php-settings/team-global-settings.php' );
require_once( get_template_directory().'/acf-php-settings/post-settings.php' );
require_once( get_template_directory().'/acf-php-settings/site-settings.php' );
require_once( get_template_directory().'/acf-php-settings/site-settings-editor.php' );
require_once( get_template_directory().'/acf-php-settings/post-category-settings.php' );

require_once( get_template_directory().'/acf-php-settings/services-settings.php' );

require_once(get_template_directory().'/common.php'); 

require_once(get_template_directory().'/functions/helper-functions.php');
require_once(get_template_directory().'/functions/set_defines.php'); 
require_once(get_template_directory().'/functions/admin-css.php'); 

// Theme support options
require_once(get_template_directory().'/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/functions/page-navi.php'); 

// Breadcrumbs
require_once(get_template_directory().'/functions/breadcrumbs.php');
require_once(get_template_directory().'/functions/menu-tree.php');
require_once(get_template_directory().'/functions/search-form.php');


// Adds support for multiple languages
require_once(get_template_directory().'/functions/translation/translation.php'); 

require_once(get_template_directory().'/functions/shortcodes.php');

require_once(get_template_directory().'/functions/override-global-cb.php');


require_once( 'hicaliber-theme-helper.php' );
require_once( 'hicaliber-theme-hero.php' );

// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php'); 

// Remove Emoji Support
// require_once(get_template_directory().'/functions/disable-emoji.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php'); 

// Use this as a template for custom post types
// require_once(get_template_directory().'/functions/custom-post-type.php');

// Customize the WordPress login menu
require_once(get_template_directory().'/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/functions/admin.php');  

//Hide ACF Menu
// if( !function_exists('dev_env')  ) {
// //	add_filter('acf/settings/show_admin', '__return_false');
// }
// Adding sites element if plugin enabled;

function svg_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
  
add_filter('upload_mimes', 'svg_mime_types');

function hical_additional_element() {

	$els = get_field('sites_elements', 'options');	
	
	if( class_exists('HICALIBER_ACCOMODATION') ) {
        $els[] = 'properties_acc';
        $els[] = 'promotions_acc';
    }

    if( class_exists('HI_PRODUCTS') ) {
        $els[] = 'products';
	}

	if( class_exists('HI_COURSES') ) {
        $els[] = 'courses';
	}
	
	if( class_exists('HI_EVENTS') ) {
        $els[] = 'events';
	}

	if( class_exists('Hicaliber_Property_Addons') ) {
		$els[] = 'listing_section';
		if(_get_field_value('op_design_post', 'options')){
			$els[] = 'designs';
		}
	}
    
	return $els;
}

function is_element_exists($element){
	return $element ? in_array($element, hical_additional_element()) : false;
}

function get_all_elements(){
	return hical_additional_element();
}

add_filter( 'register_post_type_args', 'remove_events_archive' , PHP_INT_MAX, 2 );
function remove_events_archive( $args, $post_type ){

	// Do not filter any other post type
	if ( 'tribe_events' !== $post_type ) {
	
	// Give other post_types their original arguments
	return $args;
	
	}
	
	$args['has_archive'] = false;
	// Give the custom-css-js post type it's arguments
	return $args;
	
}
/*************************************************************
* Hicaliber main setup
**************************************************************/

function _get_field($selector, $post_id = false, $format_value = true, $load_value = true) {
	$data = '';
		try {
			if(function_exists('get_field_object')) :
				if(is_home()){
					$post_id = $post_id ? $post_id : get_option( 'page_for_posts' );	
				}
				$data = get_field_object($selector,$post_id,$format_value, $load_value);	
			else :
				return false;
			endif;
		} catch (Exception $e) {
			return false;
		}
	return $data;  	
}

function _get_field_value($selector, $post_id = false, $format_value = true, $load_value = true) {
	$data = '';
		try {
			$obj = _get_field($selector, $post_id, $format_value, $load_value);
			if(isset($obj['value'])) $data = $obj['value'];
		} catch (Exception $e) {
			return false;
		}
	return $data;  	
}

function _get_sub_field($selector, $format_value = true, $load_value = true) {
	$data = '';
		try {
			if(function_exists('get_sub_field_object')) :
				$data = get_sub_field_object($selector,$format_value, $load_value);	
			else :
				return false;
			endif;
		} catch (Exception $e) {
			return false;
		}
	return $data;  	
}

function _get_sub_field_value($selector, $format_value = true, $load_value = true) {
	$data = '';
		try {
			$obj = _get_sub_field($selector, $format_value, $load_value);
			if(isset($obj['value'])) $data = $obj['value'];
		} catch (Exception $e) {
			return false;
		}
	return $data;  	
}

function _have_rows($selector, $post_id = false) {
	$flag = '';
		if(function_exists('have_rows')) :
			try {
				if(is_home()){
					$post_id = $post_id ? $post_id : get_option( 'page_for_posts' );	
				}
				if($post_id) $flag = have_rows($selector, $post_id);
				else $flag = have_rows($selector);
			} catch (Exception $e) {
				$flag = false;
			}
		endif;
	return $flag;  	
}

require_once(get_template_directory().'/functions/hicaliber.php'); 

function get_featured_image( $id ) {
	if ( $id ) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
		if( is_array($large_image_url) ){
			return $large_image_url[0];	
		} else {
			return "";
		}
	} else {
		return "";
	}
}

function hex2rgb($hex ) {
	$hex = str_replace("#", "", $hex);
	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	return $rgb; // returns an array with the rgb values
}

function hi_rgb( $hex,$opacity=1 ){
	if( $opacity == "" ){
		$opacity=1;
	} else {
		$opacity = ".".$opacity;
	}	
	$final_rgb = implode(", ", hex2rgb($hex) );
	return 'background-color: rgba('. $final_rgb . ','.$opacity.')';
}

function hi_get_posts($posts_per_page, $post_type, $order) {
	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type' =>	$post_type,
		'status'	=>	'publish',
		'order'		=>	$order,
		'orderby'	=>	'date'
	);
	return New WP_Query( $args );
}

function hic_force_phone_number($inp){
    $result=array();
    $inp = str_replace(array('[',']','(',')'), '', strtolower($inp));
    $keypad = array('a' => '2', 'b' => '2', 'c' => '2', 'd' => '3',
        'e' => '3', 'f' => '3', 'g' => '4', 'h' => '4',
        'i' => '4', 'j' => '5', 'k' => '5', 'l' => '5',
        'm' => '6', 'n' => '6', 'o' => '6', 'p' => '7',
        'q' => '7', 'r' => '7', 's' => '7', 't' => '8',
        'u' => '8', 'v' => '8', 'w' => '9', 'x' => '9',
        'y' => '9', 'z' => '9');

    for ($x=0; $x<strlen($inp); $x++){
        $letter = $inp[$x];
        if (isset($keypad[$letter]) ?  $keypad[$letter] : false ) $result[]= $keypad[$letter];
        else $result[]= $letter;
    }
    return implode('',$result);
}

function set_social_media() {  
    echo get_social_media();
}

function get_social_media($iconset=1) {  
    

		$ico_set = array(
		1 => array(
			'facebook'	=> '<i class="fab fa-facebook-f"></i>',
			'pinterest'	=> '<i class="fab fa-pinterest-p"></i>',
			'twitter'	=> '<i class="fab fa-twitter"></i>',
			'linkedin'	=> '<i class="fab fa-linkedin-in"></i>',
			'instagram'	=> '<i class="fab fa-instagram"></i>',
			'youtube'	=> '<i class="fab fa-youtube"></i>'
		),
		2 => array(
			'facebook'	=> '<i class="fab fa-facebook-square"></i>',
			'pinterest' 	=> '<i class="fab fa-pinterest-square"></i>',
			'twitter'	=> '<i class="fab fa-twitter-square"></i>',
			'linkedin'	=> '<i class="fab fa-linkedin"></i>',
			'instagram'	=> '<i class="fab fa-instagram"></i>',
			'youtube'	=> '<i class="fab fa-youtube"></i>'
		),
		3 => array(
			'facebook'	=> '<i class="fab fa-facebook"></i>',
			'pinterest'	=> '<i class="fab fa-pinterest-p"></i>',
			'twitter'	=> '<i class="fab fa-twitter"></i>',
			'linkedin'	=> '<i class="fab fa-linkedin-in"></i>',
			'instagram'	=> '<i class="fab fa-instagram"></i>',
			'youtube'	=> '<i class="fab fa-youtube"></i>'
		),
	);
	if(array_key_exists($iconset, $ico_set)){
		extract($ico_set[$iconset], EXTR_PREFIX_ALL, 'faicon');
	} else {
		extract($ico_set[1], EXTR_PREFIX_ALL, 'faicon');
	}


	if( hi_get_social_fb() || hi_get_social_pinterest()  || hi_get_social_twitter() || hi_get_social_linkedin() || hi_get_social_instagram() ) : 
	ob_start();
	?>

                     <div class="social-media-container">
						      
                            <ul class="social-media">
                                
                                <?php if(_get_field_value('social_facebook', 'options')) : ?>
                                <li>
                                  <a href="<?php _e(_get_field_value('social_facebook', 'options')); ?>" rel="noopener" target="_blank"><span class="hidden">Facebook</span><?php echo $faicon_facebook; ?> </a>
                                </li>
                                <?php endif; ?>

                                  
                                 <?php if(_get_field_value('social_instagram', 'options')) : ?>
                                <li>
                                  <a href="<?php _e(_get_field_value('social_instagram', 'options')); ?>" rel="noopener" target="_blank" ><span class="hidden">Instagram</span><?php echo $faicon_instagram; ?></a>
                                </li>
                                <?php endif; ?>
                                
                                  <?php if(get_field('social_pinterest', 'options')) : ?>
                                <li>
                                  <a href="<?php _e(get_field('social_pinterest', 'options')); ?>" rel="noopener" target="_blank"><span class="hidden">Pinterest</span><?php echo $faicon_pinterest; ?></a>
                                </li>
                                <?php endif; ?>
                            
                                
                                <?php if(_get_field_value('social_twitter', 'options')) : ?>
                                <li>
                                  <a href="<?php _e(_get_field_value('social_twitter', 'options')); ?>" rel="noopener" target="_blank"><span class="hidden">Twitter</span><?php echo $faicon_twitter; ?></a>
                                </li>
                                <?php endif; ?>
                                
                                
                                <?php if(_get_field_value('social_linkedin', 'options')) : ?>
                                <li>
                                  <a href="<?php _e(_get_field_value('social_linkedin', 'options')); ?>" rel="noopener" target="_blank"><span class="hidden">Linkedin</span><?php echo $faicon_linkedin; ?></a>
                                </li>
                                <?php endif; ?>
                                
                              
                                 
                                 
                                 <?php if(_get_field_value('social_youtube', 'options')) : ?>
                                <li>
                                  <a href="<?php _e(_get_field_value('social_youtube', 'options')); ?>" rel="noopener" target="_blank"><span class="hidden">Youtube</span><?php echo $faicon_youtube; ?></a>
                                </li>
                                <?php endif; ?>
                                
                              </ul>
                              
                          </div>

 <?php 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	endif; 
}



 function set_primary_number() { 
	if(is_singular('location') && _get_field_value("ls_location_custom_design", "options")){
		$phone = _get_field_value('location_phone');
		if ( $phone  ) :  ?>
			<div class="phone"><a href="tel:<?php echo $phone; ?>"><i class="fa fa-phone" aria-hidden="true"></i> <span class="number"><?php echo $phone; ?></span></a></div>
		<?php endif;
	} elseif((is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")) {
		$parent_id = _get_field_value('link_to_location');
		$phone = _get_field_value('location_phone', $parent_id);
		if ( $phone  ) :  ?>
			<div class="phone"><a href="tel:<?php echo $phone; ?>"><i class="fa fa-phone" aria-hidden="true"></i> <span class="number"><?php echo $phone; ?></span></a></div>
		<?php endif;
	} else {
		$contact = GS_COMMON::contact_details();
		$phone = isset( $contact['phone_number'] ) ||  $contact['phone_number'] != "" ? $contact['phone_number'] : "";
		if ( $phone  ) :  ?>
			<div class="phone"><a href="tel:<?php echo hic_force_phone_number(str_replace(" ", "", $phone )); ?>"><i class="fa fa-phone" aria-hidden="true"></i> <span class="number"><?php echo preg_replace('/\[.*\]/','', $phone); ?></span></a></div>
		<?php endif;
	}
 }	
 
 
 function hi_set_top_contact_info() { 
	if( (is_singular('location') || is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")){
		$id = get_the_ID();
		if(is_singular('location_post') || is_singular('location_page')) $id = _get_field_value('link_to_location');
		$contact_info = array(
			'phone_number'	=> _get_field_value('location_phone', $id),
			'email_address'	=> _get_field_value('location_email_address', $id)
		);
	} else {
		$contact_info = _get_field_value('contact_details','options');
	}
 	?>
	 <?php if( ( isset($contact_info['phone_number']) ? $contact_info['phone_number'] : false ) || 
	 	( isset($contact_info['email_address']) ? $contact_info['email_address'] : false ) ||
		 ( isset($contact_info['address_line_1']) ? $contact_info['address_line_1'] : false ) ) : ?>
 	<ul class="contact-info horizontal custom-ul">
		<?php if(  ( isset($contact_info['address_line_1']) ? $contact_info['address_line_1'] : false ) ) : ?>
		<li><div class="address">
 			<?php if($contact_info['address_google_link']): ?><a href="<?php echo $contact_info['address_google_link']; ?>"><?php endif; ?>
				<i class="fas fa-map-marker-alt"></i> <span> <?php echo $contact_info['address_line_1']; ?></span>
 			<?php if($contact_info['address_google_link']): ?></a><?php endif;?>
		</div></li>
		<?php endif; ?>
		<?php if( ( isset($contact_info['phone_number']) ? $contact_info['phone_number'] : false ) ) : ?>
		<li><div class="phone-number"><a href="tel:<?php echo hic_force_phone_number(str_replace(" " , "", $contact_info['phone_number'])); ?>"><i class="fa fa-phone" aria-hidden="true"></i> <span> <?php echo preg_replace('/\[.*\]/','',$contact_info['phone_number']); ?> </span></a></div></li>
		<?php endif; ?>
		<?php if( isset($contact_info['email_address']) ? $contact_info['email_address'] : false ) : ?>
		<li><div class="email-address"><a href="mailto:<?php echo $contact_info['email_address']; ?>"><i class="fas fa-envelope"></i> <span> <?php echo $contact_info['email_address']; ?></span> </a></div></li>
		<?php endif; ?>
		
	</ul>
	<?php endif; ?>
 <?php }

function hi_set_top_text($top_col = '') { ?>
 	<div class="text"><?php echo $top_col['text'] ?></div>
 <?php }

 function set_primary_button($link, $label) {
	return '<a href="'.$link.'" class="button primary-button uppercase">'.$label.'</a>';

}

 function set_address() { if( hi_set_company_name() || hi_set_unit() || hi_set_street_num() || hi_set_postcode() || hi_set_state() || hi_set_suburb()  ) : ?>

	<div class="address">

		<?php if (hi_set_unit() || hi_set_street_num() || hi_set_postcode() || hi_set_state() || hi_set_suburb()) : ?>

		<div>

			<svg version="1.1" class="location-ic"

				 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"

				 x="0px" y="0px" width="20.3px" height="25.2px" viewBox="0 0 20.3 25.2" style="enable-background:new 0 0 20.3 25.2;"

				 xml:space="preserve">

		

			<defs>

			</defs>

			<path class="ic" d="M10.2,0C4.6,0,0,4.6,0,10.2s10.2,15,10.2,15s10.2-9.4,10.2-15S15.8,0,10.2,0z M10.2,15.1

				c-3.5,0-6.3-2.8-6.3-6.3s2.8-6.3,6.3-6.3s6.3,2.8,6.3,6.3S13.6,15.1,10.2,15.1z"/>

			</svg>

		</div>

		<?php endif; ?>		

		<div class="company-name">

			<span><?php echo hi_set_company_name(); ?></span>

		</div>

		<div class="company-address">
			
			<?php if (hi_set_unit()) { ?>
				<?php echo hi_set_unit(); ?> <br>
			<?php } ?>

			<?php echo hi_set_street_num(); ?> <br> <?php echo hi_set_suburb(); ?> <br> <?php echo hi_set_state(); ?> <?php echo hi_set_postcode(); ?>

		</div>


	</div>

<?php endif; }





function set_business_card() { if( hi_set_abn() || hi_set_acn() ) : ?>

	

	<div class="business-card">

		<!-- ABN -->

		<?php if(hi_set_abn()) : ?>

		<div>ABN: <?php echo hi_set_abn(); ?></div>

		<?php endif; ?>

		<?php if(hi_set_acn()) : ?>

			<div>	ACN: <?php echo hi_set_acn(); ?></div>

		<?php endif; ?>

		

	</div>



<?php endif; }

function hi_social_sharing_buttons($content_to_display, $icon_set, $title, $url, $thumbnail) {
	// Get current page URL 
	$hiURL = urlencode($url);
	 // Get current page title
	$hiTitle = htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
	// $hiTitle = str_replace( ' ', '%20', get_the_title());
	
	// Construct sharing URL without using any script
	$twitterURL = 'https://twitter.com/intent/tweet?text='.$hiTitle.'&amp;url='.$hiURL.'';
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$hiURL;
	$googleURL = 'https://plus.google.com/share?url='.$hiURL;
	$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$hiURL.'&amp;title='.$hiTitle;

	//$instraURL = 'https://www.instagram.com/?url='.$hiURL;

	// Based on popular demand added Pinterest too
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$hiURL.'&amp;media='.$thumbnail.'&amp;description='.$hiTitle;

	// Add sharing button at the end of page/page content
	$content = "";
	$content .= '<div class="hi-social">';

	if(in_array('facebook', $content_to_display))
		$content .= '<a class="hi-link hi-facebook" href="'.$facebookURL.'" target="_blank">'.$icon_set['facebook']['icon'].($icon_set['facebook']['title'] ? ' <span>'.$icon_set['facebook']['title'].'</span>':'').'</a>';
	if(in_array('twitter', $content_to_display))
		$content .= '<a class="hi-link hi-twitter" href="'. $twitterURL .'" target="_blank">'.$icon_set['twitter']['icon'].($icon_set['twitter']['title'] ? ' <span>'.$icon_set['twitter']['title'].'</span>':'').'</a>';
	if(in_array('linkedin', $content_to_display))
		$content .= '<a class="hi-link hi-linkedin" href="'.$linkedInURL.'" target="_blank">'.$icon_set['linkedin']['icon'].($icon_set['linkedin']['title'] ? ' <span>'.$icon_set['linkedin']['title'].'</span>':'').'</a>';
	if(in_array('pinterest', $content_to_display))
		$content .= '<a class="hi-link hi-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">'.$icon_set['pinterest']['icon'].($icon_set['pinterest']['title'] ? ' <span>'.$icon_set['pinterest']['title'].'</span>':'').'</a>';
	
	//$content .= '<a class="hi-link hi-googleplus" href="'.$googleURL.'" target="_blank"><i class="fab fa-google-plus-g"></i></a>';
	//$content .= '<a class="hi-link hi-instra" href="'.$instraURL.'" target="_blank"><i class="fab fa-instagram"></i></a>';

	$content .= '</div>';
	
	echo $content;

};
add_filter( 'share_hook', 'hi_social_sharing_buttons', 7, 5);

// i can has custom hook
function share_hook($content_to_display, $icon_set, $title, $url, $thumbnail) {
do_action('share_hook', $content_to_display, $icon_set, $title, $url, $thumbnail);
} 



function ht_acf_insert_head() {
	?>
	<style>


	 /*Theme Settings Styling*/

	  .hic-header-section {
	  	   background-color: #f9f9f9;
	  }
	  .hic-header-section label {
	  	font-size: 14px;
	  }
	 
	  .cpt-post-type .acf-button-group label:nth-child(1),
	   .cpt-post-type .acf-button-group label:nth-child(2),
	   .cpt-post-type .acf-button-group label:nth-child(6){
	  	display: none;
	  }
	  <?php if(is_plugin_active('hicaliber-course/hi-courses.php')) : ?>
	 	.cpt-post-type .acf-button-group label:nth-child(1) {
		  	display: inline-block;
		}
	  <?php endif; ?>
	  <?php if(is_plugin_active('hicaliber-events/hi-events.php')) : ?>
	 	.cpt-post-type .acf-button-group label:nth-child(2) {
		  	display: inline-block;
		}
	  <?php endif; ?>
	  <?php if(is_plugin_active('hicaliber-product/hi-product.php')) : ?>
	 	.cpt-post-type .acf-button-group label:nth-child(6) {
		  	display: inline-block;
		}
	  <?php endif; ?>
    
    
       .acf-hidden.acf-custom-hidden, .acf-hidden.sidebar-options {
            display: block !important;
            background-color: #e2e2e2;
            pointer-events: none;
            opacity: .8;
       }
       .acf-hidden.acf-custom-hidden .acf-label label:after,
       .acf-hidden.sidebar-options .acf-label label:after {
            content: ' (Disabled)';
        }
	

	</style>

	<script>
	(function($){

		  $(document).ready(function(){
            
            //$('.acf-field-57abaf01b9a88 .acf-input').append( $('#postdivrich') );
            
        });

	})(jQuery);
	</script>
	<?php
}

add_action('acf/input/admin_head', 'ht_acf_insert_head');


add_action('admin_head', 'hi_bt_hide_menus');
 
function hi_bt_hide_menus() {
     
   if(current_user_can('administrator')) {
        ?>
        <style>
           #toplevel_page_acf-options-theme-settings{
                display:none;
            }
            #getting_started_editor {
            	display: none;
            }
        </style>
        <?php
    } else {
    	 ?>
        <style>
         #getting_started_admin {
            	display: none;
            }
        </style>
        <?php
    }
}

// programmatically create some basic pages, and then set Home and Blog
// setup a function to check if these pages exist
function the_slug_exists($post_name) {
	global $wpdb;
	if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
		return true;
	} else {
		return false;
	}
}

// create the site contact page
if (isset($_GET['activated']) && is_admin()){
    $sitemap_page_title = 'Contact';
    $sitemap_page_check = get_page_by_title($sitemap_page_title);
    $sitemap_page = array(
	    'post_type' => 'page',
	    'post_title' => $sitemap_page_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'contact'
    );
    if(!isset($sitemap_page_check->ID) && !the_slug_exists('contact')){
        $sitemap_page_id = wp_insert_post($sitemap_page);
    }
}
// create the site about us page
if (isset($_GET['activated']) && is_admin()){
    $about_page_title = 'About Us';
    $about_page_check = get_page_by_title($about_page_title);
    $about_page = array(
	    'post_type' => 'page',
	    'post_title' => $about_page_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'about-us'
    );
    if(!isset($about_page_check->ID) && !the_slug_exists('about-us')){
        $about_page_id = wp_insert_post($about_page);
    }
}
// change the Sample page to the home page
if (isset($_GET['activated']) && is_admin()){
    $home_page_title = 'Home';
    $home_page_content = '<h1>About Us</h1>
    						<p>This content is a summary message about your company. Please edit this by using Heading 1 as the Title and paragraph for your message. </p>
    						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet rutrum tortor, a posuere leo. Sed ac fermentum nulla. Ut elit odio, blandit in congue a, sagittis vel metus. Vivamus semper arcu urna, eget pulvinar ante cursus sed. Suspendisse sapien libero, bibendum a lobortis a, interdum nec lorem. Sed eu diam in urna placerat vulputate. Sed accumsan nibh ac faucibus porta. Aenean malesuada lacus sit amet eros convallis, et mollis felis convallis.</p>';
    $home_page_check = get_page_by_title($home_page_title);
    $home_page = array(
	    'post_type' => 'page',
	    'post_title' => $home_page_title,
	    'post_content' => $home_page_content,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'ID' => 2,
	    'post_slug' => 'home'
    );
    if(!isset($home_page_check->ID) && !the_slug_exists('home')){
        $home_page_id = wp_insert_post($home_page);
    }
}
if (isset($_GET['activated']) && is_admin()){
	

	// Use a static front page
	$front_page = 2; // this is the default page created by WordPress
	update_option( 'page_on_front', $front_page );
	update_option( 'show_on_front', 'page' );
}

$lblg_themename="";

if (isset($_GET['activated']) && is_admin()) {
	$primary_menu = $lblg_themename . ' Main Menu';
	$main_menu_location = 'main-nav';


	$footer_menu = $lblg_themename . ' Primary Footer Menu';
	$footer_menu_location = 'footer-links';


	// Does the menu exist already?About Us
	$main_menu_exists = wp_get_nav_menu_object( $primary_menu );

	$footer_menu_exists = wp_get_nav_menu_object( $footer_menu );

	if( !$main_menu_exists){

		  ht_create_menus($primary_menu, $main_menu_location);	
	 }

	if( !$footer_menu_exists) {

		ht_create_menus($footer_menu, $footer_menu_location);	
		
	} 

}

function ht_create_menus($menu_name, $menu_location) {

		 $menu_id = wp_create_nav_menu($menu_name);

		$home_page_title = 'Home';
		$home_page_check = get_page_by_title($home_page_title);

		$about_page_title = 'About Us';
		$about_page = get_page_by_title($about_page_title);

		$contact_page_title = 'Contact';
		$contact_page = get_page_by_title($contact_page_title);

	    // Set up default BuddyPress links and add them to the menu.
	    wp_update_nav_menu_item($menu_id, 0, array(
	    	'menu-item-title' =>  $home_page_title,
	        'menu-item-object' => 'page',
	        'menu-item-object-id' => 2,
	        'menu-item-type' => 'post_type',
	        'menu-item-status' => 'publish'));

	    wp_update_nav_menu_item($menu_id, 0, array(
	        'menu-item-title' => 'About',
	    	'menu-item-object' => 'page',
	        'menu-item-object-id' => $about_page->ID,
            'menu-item-type' => 'post_type',
	        'menu-item-status' => 'publish'));

	    wp_update_nav_menu_item($menu_id, 0, array(
	         'menu-item-title' => $contact_page_title,
	    	'menu-item-object' => 'page',
	        'menu-item-object-id' => $contact_page->ID,
            'menu-item-type' => 'post_type',
	        'menu-item-status' => 'publish'));

	     if( !has_nav_menu( $menu_location ) ){
	        $locations = get_theme_mod('nav_menu_locations');
	        $locations[$menu_location] = $menu_id;
	        set_theme_mod( 'nav_menu_locations', $locations );
	    }
	}


function redirect_login_page() {
  $login_page  = home_url( '/login/' );
  $page_viewed = basename($_SERVER['REQUEST_URI']);
 
  if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  }
}
//add_action('init','redirect_login_page');

function login_failed() {
  $login_page  = home_url( '/login/' );
  wp_redirect( $login_page . '?login=failed' );
  exit;
}
//add_action( 'wp_login_failed', 'login_failed' );
 
function verify_username_password( $user, $username, $password ) {
  $login_page  = home_url( '/login/' );
    if( $username == "" || $password == "" ) {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
//add_filter( 'authenticate', 'verify_username_password', 1, 3);

function logout_page() {
  $login_page  = home_url( '/login/' );
  wp_redirect( $login_page . "?login=false" );
  exit;
}
//add_action('wp_logout','logout_page');

function hh_agent_filter($query) {

 	if( is_admin() ) {
	    return $query;
    } 

    $meta_query = $query->get('meta_query');
      
   // var_dump($meta_query)

     if ( $query->is_post_type_archive( 'agents' ) && $query->is_main_query() ) {
	    
         $query->set('post_type', 'agents');
         $query->set('posts_per_page', 10);

          $address = '';

          if(isset($_GET['address'])) {
          	$address = (string)$_GET['address'];
          }

         

         if( (isset($_GET['address']) && $_GET['address'] != '' ) && (isset( $_GET['agent_name']) && $_GET['agent_name'] != '') ) {
	    	  	$meta_query = array(
	    	  		'relation' => 'OR',
                    array(
                        'key'       => 'agent_address',
                        'value' => $address,
                        'compare'   => 'LIKE',
                    ),
                     array(
                        'key'       => 'agent_full_name',
                        'value' => $_GET['agent_name'],
                        'compare'   => 'LIKE',
                    )
                );
				

				
				$query->set('meta_query', $meta_query);

    	 } elseif(isset($_GET['address']) && empty($_GET['agent_name'])) {
         	$meta_query = array(
                     array(
                        'key'       => 'agent_address',
                        'value' => $address,
                        'compare'   => 'LIKE',
                    )
                );


				$query->set('meta_query', $meta_query);

         } elseif(isset($_GET['agent_name']) && empty($_GET['address'])) {
				$query->set('s', $_GET['agent_name']);
         }

	}

	//  if ( $query->is_post_type_archive( 'agents' ) && $query->is_main_query() ) {
	    
 //         $query->set('post_type', 'agents');
 //         $query->set('posts_per_page', 10);

 //          if( isset( $_GET['agent_name'] ) && $_GET['agent_name'] != '' ) {
	// 		 $query->set('s', $_GET['agent_name']);
 //    	 }
	// }

	return;
}

add_action('pre_get_posts','hh_agent_filter');



add_action( 'pre_get_posts', function( $q )
{
    if( $title = $q->get( '_meta_or_title' ) )
    {
        add_filter( 'get_meta_sql', function( $sql ) use ( $title )
        {
            global $wpdb;

            // Only run once:
            static $nr = 0; 
            if( 0 != $nr++ ) return $sql;

            // Modified WHERE
            $sql['where'] = sprintf(
                " AND ( %s OR %s ) ",
                $wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title),
                mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
            );

            return $sql;
        });
    }
});
add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );

function hi_search_filter($query) {

    
 	if( is_admin() ) {
	    return $query;
    } 
    
    if ($query->is_search) {
        $query->set('post_type', 'post');
        $query->set('posts_per_page', 5);
    }
    return $query;
}

//add_filter('pre_get_posts','hi_search_filter');

function hi_set_pageid($field='') {
	if($field) {
		echo 'id="'.$field.'"';
	}
	echo '';
}
function hi_set_section_header($section_title='',$split_section_title='',$section_title_color='',$section_sub_title='') {
	if($split_section_title) {
 		$color_section_title = '<span>'.$section_title_color.'</span>';
 	} else {
 		$color_section_title = '';
 	}
	 ?>
	<?php if($section_title) : ?>
		<div class="medium-12 columns section-header text-center">
			<h2 class="section-title"><?php echo $section_title; ?> <?php echo $color_section_title; ?></h2>
			<?php if($section_sub_title) : ?>
				<p><?php echo $section_sub_title; ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php }

function hi_set_element_theme($page_element='') {
	$design_options = _get_field_value($page_element);
	return $design_options['theme'];
}
function hi_set_element_alignment($page_element='') {
	$design_options = _get_field_value($page_element);
	return $design_options['text_alignment'];
}

require_once(get_template_directory() . '/functions/hcPageHelper.php');

// Page Content Builder
require_once 'page-content-builder/assets/functions/pcb.php';

// FAQ Module
require_once 'faq-module/faq.php';

// Testimonials Module
require_once 'testimonials-module/testimonials.php';

// Gallery Module
require_once 'gallery-module/gallery.php';

// Serives Module
require_once 'services-module/services.php';

//Product Page Slug Body Class

// Project Module
if( _get_field_value('sites_elements','options') && in_array('location', _get_field_value('sites_elements','options')) ) :
	require_once 'location-module/location.php';
endif;

/*************************************
 * Register scripts and stylesheets
 * ***********************************/ 

require_once(get_template_directory().'/all_assets.php'); 

function add_slug_body_class( $classes ) {

	global $post;

	if ( isset( $post ) && !is_front_page() ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

		return $classes;

}

add_filter( 'body_class', 'add_slug_body_class' );

// Project Module
if( _get_field_value('sites_elements','options') && in_array('projects', _get_field_value('sites_elements','options')) ) :
	require_once 'project-module/project.php';
endif;

// Project Module
if( _get_field_value('sites_elements','options') && in_array('team', _get_field_value('sites_elements','options')) ) :
	require_once 'team-module/team.php';
endif;

// Hic Catch
//require_once 'hic_catch/catch.php';

//pull data tags from rex
add_action('admin_init','customize_meta_boxes');
function customize_meta_boxes() {
	remove_meta_box('postcustom','page','normal');
}

global $post;

if(is_admin()){
	
	/*
	$tags = "SELECT post_id, meta_value FROM `wp_postmeta`  WHERE `meta_key` LIKE 'property_tags_single'";
    
	$tags = $wpdb->get_results($tags);
	
    if(isset($_GET['post'])){
        $post_id = $_GET['post'];
		if($tags){
			foreach($tags as $tag){
				$uns_tags = unserialize($tag->meta_value);
				if($uns_tags){
					foreach($uns_tags as $uns_tag){
						add_post_meta($post_id, 'tag_datas', $uns_tag);

						// var_dump($posts_with_meta);
					}	
				}
			}	
		}
    }
    function load_field( $field ) {
        if(isset($_GET['post'])){
            $post_id = $_GET['post'];
            $field['choices'] = array();
            $tags_meta = get_post_meta( $post_id, 'tag_datas',false);
            
            if( is_array($tags_meta) ) {
                
                foreach( $tags_meta as $choice ) {
                    
                    $field['choices'][ $choice ] = $choice;
                }
                
            }
        }
        
        return $field;
	}
	*/
    
    function custom_page_main_menu( $field ) {        
        global $wpdb; 
        $field['choices'] = [];
        $resgistered_menu = GS_COMMON::resgistered_menu();
        
        foreach( $resgistered_menu as $key => $value ) {
            $field['choices'][ $key ] = $value;
        }
        return $field;
    }
	
	/*
    add_filter('acf/load_field/name=property_tags', 'load_field');
    add_filter('acf/load_field/name=properties_listing_tags', 'load_field');
	add_filter('acf/load_field/name=properties_2_listing_tags', 'load_field');
	*/
    
    // populate the Menu option
    add_filter('acf/load_field/name=page_menu_item', 'custom_page_main_menu');
    add_filter('acf/load_field/name=member_type_main_menu', 'custom_page_main_menu');
	add_filter('acf/load_field/name=member_type_footer_menu', 'custom_page_main_menu');
	add_filter('acf/load_field/name=location_menu_item', 'custom_page_main_menu');
    
}
//end tags


//Testimonials On/Off - refactor
$s_elements = _get_field_value('sites_elements','options');


function hi_grant_gforms_editor_access() {
	$role = get_role( 'editor' );
	$role->add_cap( 'gform_full_access' );
}
// Tie into the 'after_switch_theme' hook
add_action( 'init', 'hi_grant_gforms_editor_access' );

// custom login for theme
require_once(get_template_directory().'/functions/login-style-helper.php');

function theme_custom_login() {
	echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/assets/css/hic-login-styles.css" />';
}

add_action('login_head', 'theme_custom_login');
if(in_array('wordpress-seo/wp-seo.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
    add_filter('wpseo_opengraph_image' , '__return_false' );
}

// Remove unnecessary attribute for style
add_filter( 'style_loader_tag',  'clean_style_tag'  );

/**
 * Clean up output of stylesheet <link> tags
 */
function clean_style_tag( $input ) {
    preg_match_all( "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches );
    if ( empty( $matches[2] ) ) {
        return $input;
    }
    // Only display media if it is meaningful
    $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';

    return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

// To be refactor 	
class HicPostWidget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'hic-post-widget',
			'description' => 'A list of post',
		);
		parent::__construct( 'hic_recent_post', 'Hicaliber Posts Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		$post_number = ( ! empty( $instance['post_number'] ) ) ? $instance['post_number'] : '';
		$type = ( ! empty( $instance['post_type'] ) ) ? $instance['post_type'] : '';
		$orderby = ( ! empty( $instance['order_by'] ) ) ? $instance['order_by'] : '';
		$order = ( ! empty( $instance['order'] ) ) ? $instance['order'] : '';
		
		
		
			echo do_shortcode('[hic-posts post_per_page='.$post_number.' show_post='.$type.' orderby='.$orderby.' order='.$order.']');
		
		
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		$post_number = ! empty( $instance['post_number'] ) ? $instance['post_number'] : esc_html__( 'Number of Post to show', 'text_domain' );
		$post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : esc_html__( 'Show', 'text_domain' );
		$order_by = ! empty( $instance['order_by'] ) ? $instance['order_by'] : esc_html__( 'Order by', 'text_domain' );
		$order = ! empty( $instance['order'] ) ? $instance['order'] : esc_html__( 'Order', 'text_domain' );

		?>
				<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><?php esc_attr_e( 'Number of Post to show:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number" value="<?php echo esc_attr( $post_number ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>">Show</label>
			<select class="widefat " id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
					<option value="" selected="selected">All posts</option>
					<option <?php if ( 'featured' == $post_type ) echo 'selected="selected"'; ?> value="featured">Featured Posts</option>            		
			</select>
		</p>
		
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>">Order by</label>
			<select class="widefat " id="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order_by' ) ); ?>">					
					<option <?php if ( 'date' == $order_by ) echo 'selected="selected"'; ?> value="date">Date</option>            		
            		<option <?php if ( 'rand' == $order_by ) echo 'selected="selected"'; ?> value="rand">Random</option>
			</select>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">Order</label>
			<select class="widefat " id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">					
					<option <?php if ( 'asc' == $order ) echo 'selected="selected"'; ?> value="asc">ASC</option>
            		<option <?php if ( 'desc' == $order ) echo 'selected="selected"'; ?> value="desc">DESC</option>            		
			</select>
		</p>

	
       
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['post_number'] = ( ! empty( $new_instance['post_number'] ) ) ? sanitize_text_field( $new_instance['post_number'] ) : '';
		$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? $new_instance['post_type'] : '';
		$instance['order_by'] = ( ! empty( $new_instance['order_by'] ) ) ? $new_instance['order_by'] : '';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? $new_instance['order'] : '';	
		
		return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'HicPostWidget' );
});

function force_balance_tags_trim_words($content, $max_word = 20, $force_tags=true){
	if($max_word && $force_tags){
		return force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop( $content ) ) , $max_word ) ) );
	} elseif($max_word && !$force_tags){
		return wp_trim_words( wpautop( $content ), $max_word );
	} elseif(!$max_word && $force_tags) {
		return force_balance_tags( html_entity_decode( htmlentities( wpautop( $content ) ) ) );
	} else {
		return wpautop( $content );
	}
}


// function single_template_override($single_template){
// 	global $post;
// 	 if ($post->post_type == 'post') {
// 		 $single_template = get_template_directory() . '/single-posts.php';
// 	 } 
// 	 return $single_template;
// }

// add_filter( 'single_template', 'single_template_override' );


function hic_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'hic_mime_types');


function hic_acf_format_text_value( $value, $post_id, $field ) {

    // Render shortcodes in all text values.
    return do_shortcode( $value );
}

add_filter('acf/format_value/type=text', 'hic_acf_format_text_value', 10, 3);


function hi_populate_sidebar( $field ) {   
			
	$hs = new hicaliber_theme_helpers;

	$field['choices'] = [];

	$sidebars = $hs->hi_get_registered_sidebars();

	if($sidebars) {
		foreach( $sidebars as $key => $value ) {
			$field['choices'][ $key ] = $value['name'];		
		}
	}
	return $field;
}


	// Populate sidebar options
	add_filter('acf/load_field/name=sp_left_sidebar',  'hi_populate_sidebar' );
	add_filter('acf/load_field/name=sp_right_sidebar',  'hi_populate_sidebar' );
	add_filter('acf/load_field/name=ap_left_sidebar',  'hi_populate_sidebar' );
	add_filter('acf/load_field/name=ap_right_sidebar',  'hi_populate_sidebar' );
	add_filter('acf/load_field/name=cp_left_sidebar',  'hi_populate_sidebar' );
	add_filter('acf/load_field/name=cp_right_sidebar',  'hi_populate_sidebar' );

add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'hicaliber-site-settings',
        'title' => 'Site Settings',
        'href'  => home_url() . '/wp-admin/admin.php?page=acf-options-site-settings',
        'meta'  => array(
            'title' => __('Site Settings'),            
        ),
	));
}

function hi_remove_string_special_char($string) {

	$clean_string = '';

	if($string) {
		$clean_string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);	
	}

	return $clean_string;
}