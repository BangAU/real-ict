<?php

    global $post;
        
    $id = '';
    if($post) $id = $post->ID;
    
    $pcb = new hcContentBuilder(); 

    if(is_home()) {
        $id = get_option( 'page_for_posts' );
    }

    $search_form_type = $id ? get_field('search_listing_layout', $id) : get_field('search_listing_layout');
    $header = _get_field_value('cpt_content_header');
    
    $design_categories = _get_field_value('designs_categories');

    if(is_array($design_categories)){
        $design_categories = implode(",", $design_categories);
    }
    
    $hs = new hicaliber_theme_helpers;
     
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'listing-element', 'design-listing-element', 'image-'._get_field_value('designs_image_type', $id), _get_field_value('display', $id), 'grid', _get_field_value('theme', $id), _get_field_value('element_width', $id), _get_field_value('section_classes', $id), _get_field_value('text_alignment', $id) ]
    );
    
?>

<section <?php hi_set_pageid( _get_field_value('section_id') ); ?> class="<?php echo $section_css; ?>">
    <div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($header); ?>
            <?php 
                if( class_exists('HPLA') ) {
                    $sc_param = ""; 
                    $form_classes = 'design-search';
                    $sc_param = ""; 
                    
                    $sc_param .=  HPLA::set_shortcode_param( 'search-title' , _get_field_value('property_search_form_title') );
                    $sc_param .=  HPLA::set_shortcode_param( 'search-form'  , _get_field_value('show_search_form') ? 'on' : 'off'  );
                    $sc_param .=  HPLA::set_shortcode_param( 'search-filter-layout'  , $search_form_type  );
                    $sc_param .=  HPLA::set_shortcode_param( 'show-search-filter-form'  , _get_field_value('show_property_search_form', $id) ? 'on' : 'off' );
                    $sc_param .=  HPLA::set_shortcode_param( 'classes'  , $form_classes );
                    $sc_param .=  HPLA::set_shortcode_param( 'item-limit' , _get_field_value('op_property_to_show') );
                    $sc_param .=  HPLA::set_shortcode_param( 'no-result-text' , _get_field_value('no_search_results') );
                    $sc_param .=  HPLA::set_shortcode_param( 'image-type' , _get_field_value('designs_image_type') );
                    $sc_param .=  HPLA::set_shortcode_param( 'col-item', _get_field_value('per_row'));
                    $sc_param .=  HPLA::set_shortcode_param( 'categories' , $design_categories );
                    $sc_param .=  HPLA::set_shortcode_param( 'pagination', 'on' );
                    echo do_shortcode("[design-listing $sc_param]");
                }
            ?>
        </div>
    </div>
</section>