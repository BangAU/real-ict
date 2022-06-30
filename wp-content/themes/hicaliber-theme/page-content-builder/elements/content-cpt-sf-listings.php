<?php

    global $post;
        
    $id = '';
    if($post) $id = $post->ID;
    
    $pcb = new hcContentBuilder(); 
    
    if(is_home()) {
        $id = get_option( 'page_for_posts' );
    }
    
    $categories = $id ? _get_field_value('listing_categories', $id) : _get_field_value('listing_categories');

    if($categories) {
        $categories = implode(',', $categories);
    } else {
        $categories = '';
    }

    $listing_type = $id ? _get_field_value('property_search_listing_types', $id) : _get_field_value('property_search_listing_types');
    $price_type = $id ? _get_field_value('property_search_pricing_types', $id) : _get_field_value('property_search_pricing_types');
    $search_form_type = $id ? _get_field_value('search_form_type', $id) : _get_field_value('search_form_type');
    $content_to_display = $id ? _get_field_value('property_content_to_display', $id) : _get_field_value('property_content_to_display');;

    $header = _get_field_value('cpt_content_header');
    $hs = new hicaliber_theme_helpers;

    $post_type = _get_field_value('post_type');

    if($content_to_display) {
        $content_to_display = implode(',', $content_to_display);
    } else {
        $content_to_display = '';
    }
     
    if($listing_type == 'all'){
        $all_choices = isset(_get_field('property_search_listing_types')['choices']) ? _get_field('property_search_listing_types')['choices'] : array();
        if($all_choices){
            unset($all_choices['all']);
            $listing_type = implode(",",array_keys($all_choices));
        }
    }

    if($price_type == 'all'){
        $all_choices = isset(_get_field('property_search_pricing_types')['choices']) ? _get_field('property_search_pricing_types')['choices'] : array();
        if($all_choices){
            unset($all_choices['all']);
            $price_type = implode(",",array_keys($all_choices));
        }
    }

    $section_css = "";
    
    $section_css = $hs::css_class_helper(
       [ 'page-element', 'listing-element', 'property-listing-element', 'image-'._get_field_value('properties_image_type'), _get_field_value('display'), 'grid', _get_field_value('cpt_grid_layout'), _get_field_value('theme'), _get_field_value('element_width'), _get_field_value('section_classes'), _get_field_value('text_alignment') ]
    );

?>

<section <?php hi_set_pageid( _get_field_value('section_id') ); ?> class="<?php echo $section_css; ?>">
    <div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($header); ?>
            <?php 
                if( class_exists('HPLA') ) {
                    $sc_param = ""; 
                    $form_classes = $listing_type ? $listing_type . '-search' : '';
                    $form_classes .= $search_form_type ? ' ' . $search_form_type : '';
                    
                    $property_tags = "";
                    
                    if( !empty ( _get_field_value('property_tags') ) ) {
                        if( is_array( _get_field_value('property_tags') ) ) {
                            $property_tags = implode( ",", _get_field_value('property_tags')  );
                        }
                    }
                    
                    $sc_param .=  HPLA::set_shortcode_param( 'search-title' , _get_field_value('property_search_form_title') );
                    $sc_param .=  HPLA::set_shortcode_param( 'search-form'  , _get_field_value('show_search_form', $id)  ? 'on' : 'off' );
                    $sc_param .=  HPLA::set_shortcode_param( 'show-search-filter-form'  , _get_field_value('show_property_search_form', $id) ? 'on' : 'off' );    
                    $sc_param .=  HPLA::set_shortcode_param( 'classes'  , $form_classes );
                    $sc_param .=  HPLA::set_shortcode_param( 'categories', $categories);
                    $sc_param .=  HPLA::set_shortcode_param( 'listing-type' , $listing_type );             
                    $sc_param .=  HPLA::set_shortcode_param( 'price-type' , $price_type );
                    $sc_param .=  HPLA::set_shortcode_param( 'item-limit' , _get_field_value('op_property_to_show') );
                    $sc_param .=  HPLA::set_shortcode_param( 'searchbox-placeholder' , _get_field_value('search_filter_placeholder') );
                    $sc_param .=  HPLA::set_shortcode_param( 'no-result-text' , _get_field_value('no_search_results') );
                    $sc_param .=  HPLA::set_shortcode_param( 'image-type' , _get_field_value('properties_image_type') );
                    $sc_param .=  HPLA::set_shortcode_param( 'col-item', _get_field_value('per_row'));
                    $sc_param .=  HPLA::set_shortcode_param( 'max-number-of-words', _get_field_value('max_number_of_words'));
                    $sc_param .=  HPLA::set_shortcode_param( 'property-tags', $property_tags );
                    $sc_param .=  HPLA::set_shortcode_param( 'pagination', 'on' );
                    $sc_param .=  HPLA::set_shortcode_param( 'content-to-display' , $content_to_display );
                    
                    echo do_shortcode("[property-listing $sc_param]");
                }
            ?>
        </div>
    </div>
</section>