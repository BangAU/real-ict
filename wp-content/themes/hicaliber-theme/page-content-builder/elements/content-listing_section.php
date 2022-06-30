<?php
    
    $layout = $elements['properties_layout'];
    
    

     //Property Listing Details
    $pcb = new hcContentBuilder();
    
    //Property Details
    $property_details = $elements['properties_section_content'];
    //Property Type
    $categories = $property_details['properties_listing_categories'];
    $ls_property_price_type = $property_details['properties_price_types'];
    $listing_type = $property_details['properties_listing_types'];
    $is_featured = $property_details['properties_recent_featured'];
    $content_to_display = $property_details['content_to_display'];


    if($listing_type) {
        $listing_type = implode(',', $listing_type);
    } else {
        $listing_type = '';
    }

    if($categories) {
        $categories = implode(',', $categories);
    } else {
        $categories = '';
    }

     if($ls_property_price_type) {
        $ls_property_price_type = implode(',', $ls_property_price_type);
    } else {
        $ls_property_price_type = '';
    }

    if($content_to_display) {
        $content_to_display = implode(',', $content_to_display);
    } else {
        $content_to_display = '';
    }
    
    $design = $elements['properties_section_design'];


    $listing_tags = implode( ", ", $property_details['properties_listing_tags']) ;

    $hs = new hicaliber_theme_helpers;
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'listing-element', 'property-listing-element', 'image-'.$property_details['properties_image_type'], $layout['display'], $design['section_classes'], $layout['layout_type'], ($layout['layout_type'] =='grid') ? $layout['grid_layout']: '', $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>" data-content-listing-page="listing-element">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>
    <div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($elements['property_section_header']); ?>
                <?php 
                $sc_param = "";                    
                if( class_exists('HPLA') ) {
                    $sc_param .=  HPLA::set_shortcode_param( 'layout' , $layout['layout_type'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'col-item' , $layout['per_row'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'max-number-of-words', $property_details['max_number_of_words']);
                    $sc_param .=  HPLA::set_shortcode_param( 'categories', $categories);
                    $sc_param .=  HPLA::set_shortcode_param( 'listing-type' , $listing_type );
                    $sc_param .=  HPLA::set_shortcode_param( 'price-type' , $ls_property_price_type );
                    if(isset($layout['slider_autoplay'])){
                        $sc_param .=  HPLA::set_shortcode_param( 'autoplay' , $layout['slider_autoplay'] ) ? 'on' : 'off';
                    }
                    if(isset($layout['slider_speed'])){
                        $sc_param .=  HPLA::set_shortcode_param( 'autoplay-speed' , $layout['slider_speed'] );
                    }
                    $sc_param .=  HPLA::set_shortcode_param( 'items' , $property_details['properties_max_qty'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'recent-featured' , $is_featured );                        
                    $sc_param .=  HPLA::set_shortcode_param( 'item-limit' , $property_details['properties_max_qty'] ); 
                    $sc_param .=  HPLA::set_shortcode_param( 'image-type' , $property_details['properties_image_type'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'post' , 'no-post' );
                    $sc_param .=  HPLA::set_shortcode_param( 'property-tags' , $listing_tags );
                    $sc_param .=  HPLA::set_shortcode_param( 'content-to-display' , $content_to_display );
                    
                }
                echo do_shortcode("[property-listing-widget $sc_param]");
                ?>
            <?php $pcb->printFooter($elements['properties_section_footer']); ?>
        </div>
    </div>
</section>