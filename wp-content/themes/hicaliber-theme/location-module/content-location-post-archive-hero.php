<?php 
    
    $global_page_banner = _get_field_value('subpage_hero_img','options');
    
    $banner_img = null;
    if (!$banner_img) {
		$banner_img = $global_page_banner;
	}

	$page_title = get_the_title();
	$page_desc = "";
    if(is_singular('location')){
        $location_id = get_the_ID();
    } elseif(is_singular('location_post') || is_singular('location_page')) {
        $location_id = _get_field_value('link_to_location');
    }

    if($location_id) {
        
		$banner_options = _get_field_value('location_post_single_banner_options','options');
		
		if( isset($banner_options['location_post_single_page_banner']) ? $banner_options['location_post_single_page_banner'] : false ) {
		    $banner_img = $banner_options['location_post_single_page_banner'];    
		}

        $args = array(
            'post_type'             => 'location_post',
            'posts_per_page'        => 1,
            'post_status'           => 'publish',
        );

        if( $location_id ) {
            $args['meta_key']   = 'link_to_location';
            $args['meta_value'] = $location_id;
        } else {
            $args['order'] = 'DESC';
            $args['orderby'] = 'date'; 
        }

        $q = new WP_Query( $args );

        if( $q->have_posts() ) : while( $q->have_posts() ) : $q->the_post(); 
            $page_title =  get_the_title();

            $page_desc = "<div class='hic-button-wrap'>";
            $page_desc .= do_shortcode('[button url="'.get_permalink().'" title="Read more"]');;
            $page_desc .= "</div>"; 

            $banner_img = get_featured_image( get_the_ID() );    

        endwhile; endif; wp_reset_postdata();
	}

	$content_args = [
	  'banner'          => true,
	  'banner_type'     => 'page-banner',
	  'hero_filter'     => "",
	  'bg_overLay'      => "rgba(10,0,0,.15)",

	//   'form_display'	=> _get_field_value('page_banner_form_display', $id),
	  'form_display'	=> false,
	  'form_options'	=> array(),


	  'show_booking_form'	=> false,
	  
	  'banner_height'   => "default-height",
	  'text_align'      => "text-left",
	  
	  'title'               => $page_title,
	  'desc'                => $page_desc,
	  'img'                 => $banner_img,
	  
	];

?>
<?php 
    $hero = new hicaliber_theme_hero();
    $hero::display( $content_args );
?>
<!-- end .hero -->