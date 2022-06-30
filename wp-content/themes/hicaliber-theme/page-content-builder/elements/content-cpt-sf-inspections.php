<?php

    global $post;
        
    $id = '';
    if($post) $id = $post->ID;
    
    if(is_home()) {
        $id = get_option( 'page_for_posts' );
    }
    
    $listing_type = $id ? get_field('property_search_listing_types', $id) : get_field('property_search_listing_types');
    $search_form_type = $id ? get_field('search_form_type', $id) : get_field('search_form_type');

    $hs = new hicaliber_theme_helpers;

    $post_type = get_field('post_type');
     
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', $post_type.'-content-boxes', 'content-boxes', 'relative', 'pt-0', 'pb-0', get_field('section_classes'), get_field('theme'), get_field('element_width'), get_field('text_alignment'), get_field('display') ]
    );
    
?>

<section <?php hi_set_pageid( get_field('section_id') ); ?> class="<?php echo $section_css; ?>">
    <?php 

        $sc_param = ""; 
        $form_classes = $listing_type ? $listing_type . '-search' : '';
        $form_classes .= $search_form_type ? ' ' . $search_form_type : '';

        $sc_param .=  HPLA::set_shortcode_param( 'search-title' , get_field('property_search_form_title') );
        $sc_param .=  HPLA::set_shortcode_param( 'search-form'  , get_field('show_property_search_form') );     
        $sc_param .=  HPLA::set_shortcode_param( 'show-search-filter-form'  , get_field('show_search_form', $id) ? 'on' : 'off' );
        $sc_param .=  HPLA::set_shortcode_param( 'classes'  , $form_classes );
        $sc_param .=  HPLA::set_shortcode_param( 'listing-type' , get_field('property_search_listing_types') );             
        $sc_param .=  HPLA::set_shortcode_param( 'price-type'   , get_field('property_search_pricing_types') );
        $sc_param .=  HPLA::set_shortcode_param( 'item-to-show' , get_field('op_property_to_show') );
        $sc_param .=  HPLA::set_shortcode_param( 'searchbox-placeholder' , get_field('search_filter_placeholder') );
        $sc_param .=  HPLA::set_shortcode_param( 'no-result-text' , get_field('no_search_results') );
        $sc_param .=  HPLA::set_shortcode_param( 'item-per-row', get_field('per_row'));
        $sc_param .=  HPLA::set_shortcode_param( 'inspection', true );

        echo do_shortcode("[inspection-listing $sc_param]");
    ?>
</section>