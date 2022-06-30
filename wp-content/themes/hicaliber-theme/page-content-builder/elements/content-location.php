<?php

$pcb = new hcContentBuilder(); 
$cat_atts = "";
$is_public = _get_field_value('ls_single_page', 'options');
$layout = $elements['pe_locations_layout'];
$PCBPrj = new hcPCBLocation();
$PCBPrj->addDefaultSectionClasses($layout['display']);
$pcb->setContentType($PCBPrj);

$pcb->addClassesTo('section', [$layout['layout_type']]);
if($layout['layout_type'] == 'grid') { 
    $pcb->addClassesTo('section', [$layout['grid_layout']]);
}

$id = get_the_ID();
$include_based_on_location = [];


$pcb->setSettings($elements['pe_locations_design']);

$pcb->setData('item-col', $layout['per_row']);
 if($layout['slider_autoplay']) {
     $pcb->setData('autoplay', 1);
}
if($layout['slider_autoplay']) {
     $pcb->setData('autoplay-speed', $layout['slider_speed']);
}


if( isset( $elements['pe_locations_header'] ) ) {
    $pcb->setHeader($elements['pe_locations_header']);
}
if( isset( $elements['pe_locations_footer'] ) ) {
    $pcb->setFooter( $elements['pe_locations_footer'] );    
}

$content_options = $elements['pe_locations_content'];    

$categories = $content_options['categories'];
$text_to_display = $content_options['text_to_display'];
$content_to_display = $content_options['location_content_to_display'];
$max_word = $content_options['max_number_of_words'];
$filter_options = !empty( $content_options['search_filter'] ) ? $content_options['search_filter'] : "";
$category_display = $filter_options == 'categories';


if( is_array($content_to_display) ? !in_array('button', $content_to_display) : false || !$content_to_display ) $pcb->addClassesTo('section', ['button-hidden']);

$listing_button_settings = _get_field_value('pjgs_action_btn_main', 'options');

$button_label = _get_field_value("ls_learn_more_label", "options");
$button_label = $button_label ? $button_label : "Read More";

$posts_per_page = $content_options['quantity'] ? $content_options['quantity'] : -1;

$orderby = !empty( $content_options['order_by'] ) ? $content_options['order_by'] : "";
$order = !empty( $content_options['order'] ) ? $content_options['order'] : "";

if( $text_to_display == 'description') {
    $pcb->addClassesTo('section', 'has-description');
}

if( $text_to_display == 'excerpt') {
    $pcb->addClassesTo('section', 'has-excerpt');
}

$atts = '';

    if($layout['layout_type'] == 'map') { 
        
        if( $content_options['featured'] == "select" ) {
           
            if( !empty( $content_options['selected_location'] )  ) {
                if( is_array( $content_options['selected_location'] ) ) {
                    $ids = implode(",", $content_options['selected_location'] );
                    $atts  = "ids='$ids'";
                }
            }  
           
        } elseif( $content_options['featured'] == "featured" ) {
            $atts  = "ids='featured'";
        } else {
           if( !empty($categories)  ) {
                if( is_array( $categories ) ) {
                    $categories = implode(",", $categories );
                    $atts  = "category='$categories'";
                }
            }  
        }
            
        
        $hicBox = new hcPCBLocation();
			if( !empty( $category_display ) && $category_display) {

				$terms = [];

				$cat_params = [
					'hide_empty' => true,
				];

				if( !empty( $categories )  ) {
					$cat_params['include'] = $categories;
				}

				$terms = get_terms( 'location_cat', $cat_params );

				$filter = "";
				$html_before_section = "";

				$filter .= "<div class='widget-form-inner-wrap'><ul class='location-categories list-option element-filter'>";
				$filter .= "<li class='active' data-id='{$categories}' data-filter='*'>All</li>";
				foreach ( $terms as $term ) {
					$image_icon = get_field("cat_map_image_icon", $term);

					if(!empty($image_icon)):
						$filter .= "<li data-id='{$term->term_id}' data-slug='{$term->slug}' data-filter='.{$term->slug}'>
									<span class='image-icon' style='background-image: url({$image_icon})'></span>{$term->name}
									</li>";
					else:
						$filter .= "<li data-id='{$term->term_id}' data-slug='{$term->slug}' data-filter='.{$term->slug}'>{$term->name}</li>";
					endif;
				}
				$filter .= "</ul></div>";

            	$mobile_nav =  '<div class="custom-mobile-menu filter-menu">Filter<i class="menu-icon burger-menu"></i></div>';
            	$html_before_section .= "<div class='grid-x grid-padding-x section-filter'><div class='cell'>{$mobile_nav}{$filter}</div></div>";


				$pcb->setExtraHTML($html_before_section, 1); 
			}
        $content_c =  do_shortcode("[location_map {$atts}]");
        $hicBox->setMapContent( $content_c );
        $pcb->setContentBox($hicBox);
        $pcb->displaySection(true);
    } 
    
    
    if( $layout['layout_type'] != 'map' ) :
        
    if( !empty( $category_display ) && $category_display) {
        
        $terms = [];
        
        $cat_params = [
            'hide_empty' => true,
        ];
        
        if( !empty( $categories )  ) {
            $cat_params['include'] = $categories;
        }
        
        $terms = get_terms( 'location_cat', $cat_params );
       
        $filter = "";
        $html_before_section = "";
        
        $filter .= "<ul class='isotope-nav'>";
        $filter .= "<li class='active' data-filter='*'>All</li>";
        foreach ( $terms as $term ) {
            $filter .= "<li data-filter='.{$term->slug}'>{$term->name}</li>";
        }
        $filter .= "</ul>";
        
        $html_before_section .= "<div class='grid-x grid-padding-x section-filter'><div class='cell'>{$filter}</div></div>";
        
        
        $pcb->setExtraHTML($html_before_section, 1); 
    }
    
    if( $content_options['featured'] == "select" ) {
        if( !empty( $content_options['selected_location'] ) )  {
            $args = array(
                'post_type' => 'location',
                'post__in'  => $content_options['selected_location']
            );
        }

    } else {
        $args = array(
            'post_type'         => 'location',
            'posts_per_page'    => $posts_per_page,
            'post_status'       => 'publish'
        );
        
        if(is_singular('location')){
            $args['post__not_in'] = array($id);
        }
    }
    
    if($content_options['featured']=="featured")
        $args['meta_query'] = array(
            'relation'  => 'AND',
            array(
                'key' => 'post_featured',
                'value' => 1,
                'compare' => '==' // not really needed, this is the default
            )
    );
    
    if( $categories && $content_options['featured'] != "select" ) 
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'location_cat',
                'field'     => 'id', 
                'terms'     => $categories,
                'operator' => 'IN'
            )
    );

    if( $orderby ) {
        $order = strtoupper( $order );
        if( $orderby == "alpha" ) {
            $args['orderby'] = "title";
            $args['order'] = "{$order}";
        } elseif( $orderby == "rand"  ) {
            $args['orderby'] = 'rand';
        } else {            
            $args['orderby'] = "date";
            $args['order'] = "{$order}";
        }        
    }
    
    $q = new WP_Query( $args );

        if(  $q->have_posts() ) : while( $q->have_posts() ) : $q->the_post();
        
            $content = "";
            if( $text_to_display == 'excerpt' && has_excerpt() ){
                $content = wpautop( get_the_excerpt() );
            } else {
                $max_word = $text_to_display == 'description' && $max_word ? $max_word : 20;
                $content = force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop( get_the_content() ) ) , $max_word ) ) );
            }
            
            $cat = get_the_category();
            
            $location_terms = get_the_terms(get_the_ID(), 'location_cat');
            $los = [];
            
            if( $location_terms ) {
                foreach( $location_terms as $term ) {
                    $los[] = $term->slug;
                }
            }
            
            $los = implode(" ", $los );
            
            $hicBox = new hcPCBLocation();
            $hicBox->setClassesOf('hic-box-container', [ $layout['per_row'] , 'location-item' , $los ]);
            $hicBox->setTitle( get_the_title() );
    
            if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
                $terms = get_the_terms(get_the_ID(), 'location_cat');
                if($terms && is_array($terms)) $hicBox->setTerms($terms);
            }
            if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicBox->setContent(  $content );
            $hicBox->setImage(new hcPCBLink( get_featured_image( get_the_ID() ) ));
            
            if(isset($content_options['show_gallery']) ? $content_options['show_gallery'] : false ){
                if(isset($content_options['gallery_options']) ? $content_options['gallery_options'] : false){
                    $new_options = array_merge($content_options['gallery_options'], array('thumb_center_mode' => false, 'thumb_to_show' => 5, 'thumb_arrows' => false, 'thumb_dots' => true) );
                    $hicBox->setGalleryOptions($new_options);
                }
                $images = _get_field_value('gallery');
    
                if($images) $hicBox->setGalleryImages($images);
                if($video) $hicBox->setVideo2(new hcPCBLink($video['youtube_video']));
            }
            
            if( is_array($content_to_display) ? in_array('contact', $content_to_display) : false ) {
                $hicBox->setLocation(get_field('location_address'));
                $hicBox->setEmail(get_field('location_email_address'));
                $hicBox->setPhone(get_field('location_phone'));
                $hicBox->setWebsite(get_field('location_website'));
            }
            //Contact Details
            
            //Checking if Single Post is enable, Button will not display if Single Post is disabled
            if($is_public) {
                $button = new hcPCBButtonElement();
                $button->constructButton(get_the_permalink(), $button_label );
                $hicBox->setButton($button); 
            }
            $hicBox->setIsPublic($is_public);
            
            if(_get_field_value('post_featured')) {
                $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
            }
            
            $pcb->setContentBox($hicBox);
            
        endwhile; 
    
        $pcb->displaySection();
        
        endif;
        
        wp_reset_postdata(); 
    
    endif;
   

?>