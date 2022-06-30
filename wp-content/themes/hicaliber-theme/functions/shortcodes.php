<?php 


	function hic_social_media($atts) {
	    extract(shortcode_atts( array(
			'iconset' => '1'
		), $atts));
		
		ob_start();
		
		echo get_social_media(intval($iconset));
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	 add_shortcode('social_media', 'hic_social_media' );
	 
	 function set_contact_info(){
		echo get_contact_info();
	 }

	 function hic_contact_info($atts) {
		extract(shortcode_atts( array(
			'data' => 'address,phone,email',
			'disable_html' => '0',
			'separator' => ', '
		), $atts));

		$disable_html = $disable_html == "1" ? true : false;

		ob_start();
		
		echo get_contact_info($data, $disable_html, $separator);
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	 add_shortcode('contact_info', 'hic_contact_info' );

	 function get_contact_info($datas="address,phone,email", $no_html=false, $separator=", "){
		$datas = $datas ? $datas : 'address,phone,email';

		$datas = explode(",",$datas);
		ob_start();
		
		if(!$no_html) : ?>
			<div class="contact-details">
				<?php foreach($datas as $data) : ?>
					<?php if($data == "address" && MAIN_AGENT_ADDRESS) : ?>
						<div class="contact-address">
								<i class="fa fa-map-marker" aria-hidden="true"></i>
							<?php if(MAIN_ADDRESS_LINK) : ?>
								<a href="<?php echo MAIN_ADDRESS_LINK; ?>" rel="noopener" target="_blank">
							<?php endif; ?>

								<?php _e(MAIN_AGENT_ADDRESS); ?>

							<?php if(MAIN_ADDRESS_LINK) : ?>
								</a>
							<?php endif; ?>
								
						</div>
					<?php elseif($data == "company" && MAIN_AGENT_NAME) : ?>
						<div class="contact-company"> 
							<?php _e(MAIN_AGENT_NAME); ?>
						</div>
					<?php elseif($data == "tagline" && MAIN_AGENT_POSITION) : ?>
						<div class="contact-tagline"> 
							<?php _e(MAIN_AGENT_POSITION); ?>
						</div>
					<?php elseif($data == "abn" && MAIN_AGENT_ABN) : ?>
						<div class="contact-abn"> 
							<?php _e(MAIN_AGENT_ABN); ?>
						</div>
					<?php elseif($data == "phone" && MAIN_AGENT_PHONE) : ?>
						<div class="contact-phone">
							<i class="fa fa-phone" aria-hidden="true"></i> 
							<a href="tel:<?php _e(hic_force_phone_number(str_replace(' ', '', MAIN_AGENT_PHONE))); ?>"><?php _e(preg_replace('/\[.*\]/','',MAIN_AGENT_PHONE)); ?></a>
						</div>
					<?php elseif($data == "email" && MAIN_AGENT_EMAIL) : ?>
						<div class="contact-email">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<a href="mailto:<?php _e(MAIN_AGENT_EMAIL); ?>"><?php _e(MAIN_AGENT_EMAIL); ?></a>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div><?php 
		else : 
			foreach($datas as $index => $data) :
				if($data == "address") : 
					$datas[$index] = MAIN_AGENT_ADDRESS ? MAIN_AGENT_ADDRESS : NULL;
				elseif($data == "company") : 
					$datas[$index] = MAIN_AGENT_NAME ? MAIN_AGENT_NAME : ""; 
				elseif($data == "tagline") : 
					$datas[$index] = MAIN_AGENT_POSITION ? MAIN_AGENT_POSITION : ""; 
				elseif($data == "abn") : 
					$datas[$index] = MAIN_AGENT_ABN ? MAIN_AGENT_ABN : ""; 
				elseif($data == "phone") : 
					$datas[$index] = MAIN_AGENT_PHONE ? MAIN_AGENT_PHONE : ""; 
				elseif($data == "email") : 
					$datas[$index] = MAIN_AGENT_EMAIL ? MAIN_AGENT_EMAIL : "";
				else :
					$data[$index] = "";
				endif; 
			endforeach; 
			$datas = array_filter($datas);
			if($separator == "\n") _e(wpautop(implode( $separator, $datas ))); 
			else _e(implode($separator, $datas));
		endif; 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	 }

function ht_set_current_year( $atts ) { 
 	return date('Y');
}
add_shortcode('hs_year', 'ht_set_current_year');

function hic_custom_recentpost($atts) {
	
	extract( shortcode_atts( array(
	    'type' => '',
		'limit' => 5,
		'show_image' => 'true',
		'featured' => 'false',
		'orderby' => 'date',
		'order' => 'DESC',
		'box' => 'false',
		'button_text' => 'Read more',
		'result_to_show' => "",
	), $atts ) ); 
	
	$current_post_id = get_the_ID();
	
	$box = $box == 'true' ? true : false;
	$result_to_show = explode(",", $result_to_show);
	$result_to_show = array_filter($result_to_show);
	
	ob_start(); 
		

	$args = array(
		'posts_per_page' => $limit,
		'post_type' =>	$type ? $type : 'post',
		'status'	=>	'publish',
		'orderby'	=>	$orderby,
		'order'		=>	$order,		
		'post__not_in' => array($current_post_id),
	);

	if($type == "location_post" && (is_singular('location') || is_singular('location_post') || is_singular('location_page') )){
	    if(is_singular('location')){
	        $location_id = get_the_ID();
	    } else {
	        $location_id = _get_field_value('link_to_location');
	    }
	    
	    $args["meta_query"] = array(
	            array(
	               'key'        => 'link_to_location',
	               'value'      => $location_id,
	               'compare'    => "="
	            )
	        );
	} 
	
	if( $featured == 'true' ){
		$args['meta_query'] = array(				
				array(
					'key'		=> 'post_featured',
					'value'		=> 1,
					'compare'	=> '='
				)			
			);
	}


	$posts = New WP_Query( $args );

	if( $posts->have_posts() ) :

		?>
			<ul class="hic-listing-widget post-listing">
		<?php
    $result_id = 0;
	while( $posts->have_posts() ) : $posts->the_post();
        $result_id = $result_id + 1;
		$featured_image = get_featured_image(get_the_ID());		
		$title = get_the_title();
		$link = get_permalink();
		$with_image = $show_image && $featured_image; 
		if(is_array($result_to_show) && !empty($result_to_show) ? in_array($result_id, $result_to_show) : true) :
            if(!$box) :
    		?><li class="listing-item<?php echo ($featured_image) ? ' has-image' : ''; ?>">
    				<?php if($with_image): ?>
    				<a href="<?php echo $link; ?>"><div class="featured-image hic-image" style="background-image: url(<?php echo $featured_image; ?>);"></div></a>
    				<?php endif; ?>
    				<div class="widget-post-content">
    						<a href="<?php echo $link; ?>" class="secondary-link"><div class="widget-post-title">
    							<?php echo $title; ?>
    						</div>
    						</a>
    						<div class="widget-meta post-date"><?php echo get_the_date(); ?></div>
    				</div>
    			
    			</li><?php
            else :
                $content = wp_trim_words(get_the_content(), 20, '...');
                $img_attr = $with_image ? ' image="' . $featured_image . '"' : '';
                $model = $type == 'post' || $type == 'location_post' ? "article" : "cbox";
                echo do_shortcode('[content_box title="' . $title . '"' . $img_attr . ' button="url=>' . $link . ',title=>' . $button_text . '" model="' . $model .  '"]' . $content . '[/content_box]');
            endif;
        endif;

	endwhile;

	?>	

	</ul>

	<?php

	endif; wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode('recent_posts', 'hic_custom_recentpost');



function hic_booking_form(){

	ob_start();
		echo do_shortcode('[search-form]');    
	return ob_get_clean();
}

add_shortcode('booking-form', 'hic_booking_form');


function hic_footer_logo(){
    $custom_footer_logo = _get_field_value('site_footer_custom_logo', 'options');
	$site_logo = ($custom_footer_logo) ? $custom_footer_logo : _get_field_value('g_site_logo', 'options');  
	
	ob_start(); ?>
    <div class="logo-wrap">
    	<?php if(!$site_logo) : ?>
    			<a href="<?php echo home_url(); ?>">
    <img class="logo show-for-large" src="<?php echo get_template_directory_uri() . '/assets/images/logo-2.v3.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>"<?php if( _get_field_value('g_site_logo_width', 'options') || _get_field_value('g_site_logo_height', 'options') ) : ?> style="width: <?php echo _get_field_value('g_site_logo_width', 'options'); ?>px; height: <?php echo _get_field_value('g_site_logo_height', 'options') ?>px"<?php endif; ?> >
    		<img class="logo hide-for-large" src="<?php echo get_template_directory_uri() . '/assets/images/logo-2.v3.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>" >
    	<?php endif; ?>
    	<a href="<?php echo ($site_logo) ? home_url() : $setting_url; ?>" <?php echo (!$site_logo) ? 'class="no-logo"' : ''; ?>>
    		<?php if( $site_logo ) : ?>
    
    				<img class="logo show-for-large" src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo('title'); ?>"<?php if( _get_field_value('site_footer_custom_logo_width', 'options') || _get_field_value('site_footer_custom_logo_height', 'options') ) : ?> style="width: <?php echo _get_field_value('site_footer_custom_logo_width', 'options'); ?>px; height: <?php echo _get_field_value('site_footer_custom_logo_height', 'options') ?>px"<?php endif; ?> >
    				<img class="logo hide-for-large" src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" >
    
    		<?php else: ?>
    		
    		<?php endif; ?>
    	</a>
    </div><?php
    $html = ob_get_contents();
	ob_end_clean();
	return $html;
}

add_shortcode('footer_logo', 'hic_footer_logo');

function hic_select_post($atts){

 	$a = shortcode_atts( array(
		'type' => 'post',
		'label' => '',
		'placeholder' => 'Select Option',
		'category'   => '',
	), $atts ); 

	$args = array(
		'posts_per_page' => -1,
		'post_type' =>	$a['type'],
		'status'	=>	'publish',
		'order'		=>	'DESC',
		'orderby'	=>	'date',
	);
	
	
	
	if($a['category']) {
	    
	    $taxonomies = get_object_taxonomies($a['type']);
	    
	    $categories = explode(",",$a['category']);
	    
        $args['tax_query'] = array(
			array(
				'taxonomy'  => $taxonomies[0],
				'field'     => 'slug', 
				'terms'     => $categories,
				'operator' => 'IN'
			),
		);
	}
	
	

	$posts = New WP_Query( $args );
	
	

	ob_start(); ?>

		<?php if( $posts->have_posts() ) : ?>

		<div class="hic-simple-select-element select-posts">
			<div class="input-group">
				<?php if($a['label']) : ?>
					<h4><?php echo $a['label']; ?></h4>
				<?php endif; ?>
				<select class="hic-select-post">
					
					<option value="" disabled selected><?php echo $a['placeholder']; ?></option>

					<?php while( $posts->have_posts() ) : $posts->the_post(); ?>

						<option value="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
	
		<?php endif; wp_reset_postdata(); ?>
	<?php return ob_get_clean();
}

add_shortcode('post_select_field', 'hic_select_post');


function hic_select_post_category($atts){

 	$a = shortcode_atts( array(
		'type' => 'post',
		'label' => '',
		'placeholder' => 'Select Option',
	), $atts ); 

	$args = array(
		'posts_per_page' => 5,
		'post_type' =>	$a['type'],
		'status'	=>	'publish',
		'order'		=>	'DESC',
		'orderby'	=>	'date',
	);

	$posts = New WP_Query( $args );



	$tax_obj = get_object_taxonomies($a['type']);	


	//var_dump($tax_obj);

	ob_start(); ?>

		<?php if( $posts->have_posts() ) : ?>

		<div class="hic-simple-select-element select-posts">
			<div class="input-group">
				<?php if($a['label']) : ?>
					<h4><?php echo $a['label']; ?></h4>
				<?php endif; ?>
				<select class="hic-select-post">
					
					<option value="" disabled selected><?php echo $a['placeholder']; ?></option>

					<?php while( $posts->have_posts() ) : $posts->the_post(); ?>

						<option value="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
	
		<?php endif; wp_reset_postdata(); ?>
	<?php return ob_get_clean();
}

add_shortcode('select-category', 'hic_select_post_category');


function hic_set_post_title($atts){

 	$a = shortcode_atts( array(
		'first_word_only' => "false",
		'append' => '',
		'prepend' => '',
	), $atts ); 


	$post_title = get_the_title(get_the_ID());

	if($a['first_word_only'] == "true") {		
		$arr = explode(' ',trim($post_title));
		$post_title = $arr[0]; // will print Test
	}

	$last_letter = substr($post_title, -1);
	
	if($a['append'] && $last_letter != 's') {
	    $post_title = $post_title.$a['append'];
	}

	if($a['prepend']) {
	    $post_title = $a['prepend'].$post_title;
	}

	ob_start(); ?>

	<?php echo $post_title; ?>
    
    


	<?php return ob_get_clean();
}

add_shortcode('post_title', 'hic_set_post_title');

function hic_set_post_cateogry($atts){ 

	$a = shortcode_atts( array(
		'no-category-text' => '',
		'separator' => ', ',
		'enclose_tag' => "",
	), $atts ); 

	$categories = "";
	
	if(is_single()){
		$category_objs = get_object_taxonomies();
		$categories = array();

		if (count($category_objs) < 2) foreach ($category_objs as $cat) {
			// if($a['enclose_tag']){
			// 	$categories[] = "<" . $a['enclose_tag'] . ">" . $cat->name . "</" . $a['enclose_tag'] . ">";
			// } else {
				$categories[] = $cat->name;	
			// }
	    } else array_push($categories, $a['no-category-text']);

	    $categories = implode($a['separator'], $categories);
	}
	
	ob_start(); ?>

	<?php echo $categories; ?>



	<?php return ob_get_clean();
}

add_shortcode('post-category', 'hic_set_post_cateogry');

function hic_get_location_detail($atts){ 
	$a = shortcode_atts( array(
		'id' => '',
		'data' => 'title',
		'first_word_only' => "false",
		'prepend' => '',
		'append' => '',
	), $atts ); 

	if($a['id']){
		$location_id = $a['id'];
	} elseif(is_singular('location')){
		$location_id = get_the_ID();
	} elseif(is_singular('location_post') || is_singular('location_page')){
		$location_id = _get_field_value('link_to_location');
	} 

	$data = "";

	ob_start();

	if($location_id){
		if($a['data'] == 'title') $data = get_the_title($location_id);
		if($a['data'] == 'phone') $data = _get_field_value('location_phone', $location_id);
		if($a['data'] == 'email') $data = _get_field_value('location_email', $location_id);
		if($a['data'] == 'company-number') $data = _get_field_value('location_company_number', $location_id);
		if($a['data'] == 'website') $data = _get_field_value('location_website', $location_id);
		if($a['data'] == 'address') $data = _get_field_value('location_address', $location_id);
	}

	if($data){
		if($a['first_word_only'] == "true") {
			$arr = explode(' ',trim($data));
			$data = $arr[0]; // will print Test
		}

		if($a['append']) {
			$data = $data.$a['append'];
		}

		if($a['prepend']) {
			$data = $a['prepend'].$data;
		}

		echo $data;
	}
		
	return ob_get_clean();
}

add_shortcode('location_detail', 'hic_get_location_detail');

function hic_get_location_social_media($atts){ 
	$a = shortcode_atts( array(
		'id' => '',
		'iconset' => '1',
	), $atts ); 

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
			'pinterest' => '<i class="fab fa-pinterest-square"></i>',
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

	$selected_set = isset($ico_set[$a['iconset']]) ? $ico_set[$a['iconset']] : $ico_set[1]; 

	if($a['id']){
		$location_id = $a['id'];
	} elseif(is_singular('location')){
		$location_id = get_the_ID();
	} elseif(is_singular('location_post') || is_singular('location_page')){
		$location_id = _get_field_value('link_to_location');
	} 

	ob_start();

	if($location_id){
		$socials = _get_field_value('location_social_media', $location_id);

		if(is_array($socials)) : 
			?><div class="social-media-container">						      
				<ul class="social-media"><?php
				foreach($socials as $social) : 
					if(is_array($social)) : extract($social); 
						$social_icon = $selected_set[$select_social_media];

						if($Link) : 
							?><li class="<?php echo $select_social_media; ?>"><a href="<?php _e( $Link ); ?>" target="_blank"><?php echo $social_icon; ?></a></li><?php
						endif;
					endif;
				endforeach;
				?></ul>
			</div><?php
		endif;
	}
		
	return ob_get_clean();
}

add_shortcode('location_social_media', 'hic_get_location_social_media');

function hic_menu($atts){ 
	$a = shortcode_atts( array(
		'theme_location' => 'main-nav',
		'name' => "",
		'class' => "vertical medium-horizontal",
		'type' => "accordion medium-dropdown",
	), $atts ); 

	if(!$a['class']) $a['class'] = "vertical medium-horizontal";

	ob_start();
		$menu_obj = array(
			'container' => false,                                               
			'menu_class' => $a['class'] . ' menu',
			'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="' . $a["type"] . '">%3$s</ul>',        		                    
			'depth' => 5,
			'theme_location' => $a['theme_location'],                                            
			'fallback_cb' => false, 
			'walker' => new Topbar_Menu_Walker()
		);

		if($a['name']){
			$menu_obj['menu'] = $a['name'];
		}

		wp_nav_menu( $menu_obj ); 
	return ob_get_clean();
}

add_shortcode('menu', 'hic_menu');

function hic_sitemap($atts){
    ob_start();
    global $post;   
    $a = shortcode_atts( array(
            'type' => '',
            'title'     => '',
			'exclude'   => '',
			'style'		=> '',
			'order'     => 'post_title',
        ), $atts);
        $post_type_string = $a['type'];
        $section_title = '<h3 class="hic-title">' . $a['title'] . '</h3>';
        $exclude = $a['exclude'];
        $order = $a['order'];
        $pages = wp_list_pages( array(
            'title_li'    => '',
            'sort_column' => $order,
            'exclude' => $exclude,
            'echo'     => 0,
        ));
       ?>
        <?php if($post_type_string == ''): ?>
        <div class="hic-sitemap<?php echo $a['style'] ? " sitemap-style-" . $a['style'] : ""; ?>">
                <?php 
                    if($a['title']) :
                    echo $section_title; 
                    endif;
                ?>        
                <div class="hic-content">
                <ul class="sitemap-items">
                    <?php echo $pages; ?>
                </ul>
                </div>
        </div>
        <?php else: ?>
            <div class="hic-sitemap<?php echo $a['style'] ? " " . $a['style'] : ""; ?>">
                <?php echo $section_title; ?>
                <div class="hic-content">
            <?php
            $categories = get_object_taxonomies($post_type_string);
            $terms = get_terms($categories[0]);
            if($terms) :
            echo '<ul class="sitemap-items">';
            foreach ( $terms as $term ) {
               echo '<li class="category"><a href="'.get_term_link($term).'">'.$term->name.'</a></li>';
                 $args = array( 
                    'posts_per_page' => -1,
                    'post_type'     => $post_type_string,
                    'post_status'   => 'publish',
                	'orderby'       => 'title',
                	'order'         => 'ASC',
                	'tax_query' => array(
						array(
							'taxonomy'  => $categories[0],
							'field'     => 'id', 
							'terms'     => $term->term_id,
							'operator' => 'IN'
						),
					)
                );
                $posts = new WP_Query($args);  
                if( $posts->have_posts() ) :
               
                     while( $posts->have_posts() ) : $posts->the_post();
                        echo '<li><a href="'.get_permalink().'">' . get_the_title() . '</a></li>';
                    endwhile; 
                
                
                else :
                    echo '<ul>';
                     echo '<li class="no-post">Sorry, there are currently no content to display.</li>';
                    echo '</ul>';
                
                endif; wp_reset_postdata(); 
            }
            echo '</ul>';
            endif;?>
             
                </div>
                </div>
        <?php endif; ?>
    <?php
    return ob_get_clean();
}

add_shortcode('sitemap', 'hic_sitemap');

function hic_button_filter( $atts ){
	extract(shortcode_atts(
		array(
			'group'      		=> "button-filter-group",
			'label'      		=> "Filter:",
			'listing_selector'  => "",
			'filters'      		=> "",
			'exclude_all'		=> "false",
			'loadmore'			=> "",
		), $atts
	) );

	$group = $group ? $group : "custom-filter-group";
	$loadmore_attr = $loadmore ? " data-loadmore='" . $loadmore ."'" : "";
	$exclude_all = $exclude_all == "true" ? true : false;
	
	ob_start(); ?>
	<div class="custom-isotope-nav-wrapper">
		<?php if($label) : ?>
			<span class="hic-label"><?php echo $label; ?></span>
		<?php endif; ?>
		<?php
		if($filters) :
			$filters = explode(",",$filters);
			if(is_array($filters) ? count($filters) > 0 : false) : 
				?><ul class='custom-isotope-nav' type="button" data-listing_selector="<?php echo $listing_selector; ?>" data-filter-group='<?php echo $group; ?>'<?php echo $loadmore_attr; ?>><?php
					if(!$exclude_all) : ?><li class='active' data-filter='*'>All</li><?php endif;
					foreach($filters as $filter) :
						$attr = explode(":",$filter);
						if(count($attr) == 2) :
							?><li data-filter='<?php echo $attr[0]; ?>'><?php echo $attr[1]; ?></li><?php
						endif;
					endforeach;
				?></ul><?php
			endif;
		endif;
		?>
	</div>
	
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}
add_shortcode('button_filter', 'hic_button_filter');