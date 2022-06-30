<?php 

    global $post;
    
	if( !is_archive() ) {
	    $id = $post->ID;
	}

    $global_page_banner = _get_field_value('subpage_hero_img','options');


    $show_page_banner = _get_field_value('show_page_banner', $id);
    $banner_type = _get_field_value( 'hero_banner_type' , $id);
    $banner_height = _get_field_value('page_banner_height', $id);
    $banner_text_alignment = _get_field_value('page_banner_text_alignment', $id);
    $banner_overlay = _get_field_value('background_overlay', $id);
    
    if(is_singular('gallery')) {
        $banner_options = get_field('gallery_single_page_banner', 'options');
        $show_page_banner = !empty($banner_options['show_page_banner']) ? $banner_options['show_page_banner'] : FALSE ;
        
        if(!empty($banner_options['cp_page_banner'])) {
            $global_page_banner = $banner_options['cp_page_banner'];
        }
        
    }


    
    if( is_home() ) {
        $id = get_option( 'page_for_posts' );
		$page_title = get_the_title($id);
    }
    
    $banner_img = null;
    if (!$banner_img) {
		$banner_img = $global_page_banner;
	}
    
	if( get_featured_image( $id ) ) {
	    $banner_img = get_featured_image( $id );
	}

	if(is_singular('post')) {
		$category_banner_options = _get_field_value('post_single_banner_options','options');
		
		if($category_banner_options && $category_banner_options['post_single_page_banner']) {
		    $banner_img = $category_banner_options['post_single_page_banner'];    
		}
	}

	if(is_singular('location')) {
		$banner_options = _get_field_value('location_single_banner_options','options');
		
		if( isset($banner_options['location_single_page_banner']) ? $banner_options['location_single_page_banner'] : false ) {
		    $banner_img = $banner_options['location_single_page_banner'];
		}

		if( isset($banner_options['show_page_banner']) ) {
		    $show_page_banner = $banner_options['show_page_banner'];
		}
	}

	if(is_singular('location_post')) {
		$banner_options = _get_field_value('location_post_single_banner_options','options');
		
		if( isset($banner_options['location_post_single_page_banner']) ? $banner_options['location_post_single_page_banner'] : false ) {
		    $banner_img = $banner_options['location_post_single_page_banner'];    
		}

		if( isset($banner_options['show_page_banner']) ) {
		    $show_page_banner = $banner_options['show_page_banner'];
		}
	}
	
	if( _get_field_value('opt_banner_image',$id) ) {
	    $banner_img = _get_field_value('opt_banner_image',$id);    
	}

	$page_title = get_the_title();
	$page_desc = "";
	
	if( is_archive() ) {
	    $page_title = post_type_archive_title( '', false );
	   
	} 

	if( is_home() ) {

     	$id = get_option( 'page_for_posts' );

       	if(  _get_field_value('page_banner_title' , $id ) ) {
		    $page_title =  _get_field_value('page_banner_title' , $id );
		} else {
			 $page_title = get_the_title($id);
		}

		if( _get_field_value('page_banner_subtitle', $id ) ) {
		    $page_desc =  '<div>'._get_field_value('page_banner_subtitle', $id).'</div>';
		} 
    }

  
	if( _get_field_value('page_banner_title') ) {
	    $page_title =  _get_field_value('page_banner_title' , $id );
	}
	
	if( _get_field_value('page_banner_subtitle') ) {
	    $page_desc =  '<div>'._get_field_value('page_banner_subtitle', $id).'</div>';
	}

	if(is_category() || is_archive() || is_tag()) { 
	    
		$term = get_queried_object();

		$banner_options = get_field('pc_banner_option', 'options');
		
		$banner_type = 'page-banner';
		
	    if(is_tax('gallery_cat')) {
		   $banner_options = get_field('gallery_cat_banner', 'options');
		   $banner_height = $banner_options['page_banner_height'];
		   $banner_text_alignment = !empty($banner_options['page_banner_text_alignment']) ? $banner_options['page_banner_text_alignment'] : 'default-alignment'; 
		   $cat_default_banner =  $banner_options['cp_page_banner'];
		}elseif(is_tag()){
			$banner_options = get_field('pt_banner_option', 'options');
			$banner_height = !empty($banner_options['banner_height']) ? $banner_options['banner_height'] : 'default-height';
		    $banner_text_alignment = !empty($banner_options['banner_alignment']) ? $banner_options['banner_alignment'] : 'default-alignment';
			$cat_default_banner = $banner_options['pc_default_banner'];
		} else {
		    $banner_height = !empty($banner_options['banner_height']) ? $banner_options['banner_height'] : 'default-height';
		    $banner_text_alignment = !empty($banner_options['banner_alignment']) ? $banner_options['banner_alignment'] : 'default-alignment';
		    $cat_default_banner = $banner_options['pc_default_banner'];
		}
		
		$default_banner_image = get_field('pc_default_banner', 'options');
		$category_banner = get_field('pc_banner_image', $term);
		
    	$page_title = single_cat_title('', FALSE);

    	$show_page_banner = !empty($banner_options['show_page_banner']) ? $banner_options['show_page_banner'] : FALSE;

    	$banner_overlay = !empty($banner_options['background_overlay']) ? $banner_options['background_overlay'] : 'rgba(10,0,0,0.5)';     

    	if($category_banner) {
    		$banner_img = $category_banner;
    	}   else if(!empty($cat_default_banner) && $cat_default_banner ) {
    			$banner_img = $cat_default_banner;
    	} 	else {
	    		$banner_img = $global_page_banner;
	    }

    }



	$form_options = _get_field_value('form_options', $id);

	$video_popup = _get_field_value('hero_banner_video_link', $id);

	$show_breadcrumbs = _get_field_value('g_site_show_breadcrumb', 'options'); 

	$content_args = [
	  'banner'          => $show_page_banner,
	  'banner_type'     => $banner_type,
	  'msg_align'       => _get_field_value('fh_marketing_message_alignment', $id),
	  'hero_filter'     => _get_field_value('home_banner_filter', $id ),
	  'bg_overLay'      => $banner_overlay,

	//   'form_display'	=> _get_field_value('page_banner_form_display', $id),
	  'form_display'	=> _get_field_value('page_banner_display', $id),
	  'form_options'	=> $form_options,


	  'show_booking_form'	=> _get_field_value('show_booking_form', $id),
	  
	  'banner_height'   => $banner_height,
	  'text_align'      => $banner_text_alignment,
	  
	  'title'               => $page_title,
	  'desc'                => $page_desc,
	  'img'                 => $banner_img,
	  
	  'hero_image_slides'  => get_field('hero_image_slides', $id),
	  'slider_autoplay_speed' => get_field('hero_slider_carousel_speed', $id),
	  'slider_autoplay'     => get_field('hero_banner_carousel_autoplay', $id),
	  'slider_arrows' 		=> get_field('hero_banner_carousel_arrow', $id),
	  'slider_dots'     	=> get_field('hero_banner_carousel_dots', $id),
	  'slider'              => get_field('hero_banner_slider_carousel', $id),
	  'bg_image_slides'     => get_field('hero_image_slides', $id),
	  'bg_gallery_content'  => get_field('f_hero_banner_content', $id),
	  'bgg_btns'            => get_field('hero_banner_button', $id),

	  'video_popup_link'			=> isset($video_popup['hero_banner_video_link_id']) ? $video_popup['hero_banner_video_link_id'] : '',
	  'video_popup_button_label'	=> isset($video_popup['hero_banner_video_link_label']) ? $video_popup['hero_banner_video_link_label'] : '',

	  'video_banner'        => _get_field_value('f_hero_banner_video_background', $id)
	  
	];

?>
<?php 
    $hero = new hicaliber_theme_hero();
    $hero::display( $content_args );
?>
<!-- end .hero -->



<?php if(!is_front_page() && $show_breadcrumbs) : ?>
<section class="element-breadcrumbs pt-20">
    <?php echo hi_breadcrumbs(); ?>
</section>
<?php endif; ?>