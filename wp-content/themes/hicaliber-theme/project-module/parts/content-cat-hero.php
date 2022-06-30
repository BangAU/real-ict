<?php 

    global $post;

    $id = $post->ID;
    
    if( is_home() ) {
        $id = get_option( 'page_for_posts' );
		$page_title = get_the_title($id);
    }
    
    $banner_img = null;

    $po = _get_field_value('pct_banner_option', 'options');


    if (!$banner_img) {
		$banner_img = _get_field_value('subpage_hero_img','options');
	}
	
	if( _get_field_value('ptc_banner_image',$id) ) {
	    $banner_img = _get_field_value('ptc_banner_image',$id);    
	}

	$page_title = get_the_title();
	$page_desc = "";

    if(is_tax()) {
    	$banner_img = $po['cp_page_banner'];
    	$queried_object = get_queried_object();  	
    	$tax_banner_img = _get_field_value('ptc_banner_image', $queried_object);
   		if($tax_banner_img) {
			$banner_img = $tax_banner_img;   			
   		}
   		$page_title = $queried_object->name;  	
    }
    
	if( _get_field_value('page_banner_title') ) {
	    $page_title =  _get_field_value('page_banner_title' , $id );
	}

	$form_options = '';
	$show_page_banner = true;
	$page_banner_text_alignment = 'text-left';
	$background_overlay = 'rgba(10,0,0,.15)';
	$page_banner_height = 'default-height';

	
	if(is_array($po)) extract($po);

	$content_args = [
	  'banner'          => $show_page_banner,
	  'banner_type'     => 'page-banner',
	  'bg_overLay'      => $background_overlay,
	  
	  'banner_height'   => $page_banner_height,
	  'text_align'      => $page_banner_text_alignment,
	  
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