<?php

    $hs = new hicaliber_theme_helpers;

    $pcb = new hcContentBuilder(); 

    $layout = $elements['design_section_layout'];
    $design = $elements['design_section_design'];
    
    $content_options = $elements['design_section_content'];
    $design_categories = $content_options['designs_categories'];

    if(is_array($design_categories)){
        $design_categories = implode(",", $design_categories);
    } 
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'listing-element', 'design-listing-element', 'image-'.$content_options['design_image_type'], $layout['design_display'], $layout['layout_type'], $design['theme'], $design['element_width'], $design['section_classes'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
    <?php echo $hs::design_background_image( $design['background_image'] ); ?>
    <div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($elements['design_section_header']); ?>
            <?php 
                if( class_exists('HPLA') ) {
                    $sc_param = ""; 
                    $sc_param .=  HPLA::set_shortcode_param( 'item-limit' , $content_options['designs_max_qty'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'image-type' , $content_options['design_image_type'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'recent-featured' , $content_options['designs_recent_featured'] );
                    $sc_param .=  HPLA::set_shortcode_param( 'col-item', $layout['per_row'] );
                    if(isset($layout['slider_autoplay'])){
                        $sc_param .=  HPLA::set_shortcode_param( 'autoplay' , $layout['slider_autoplay'] ) ? 'on' : 'off';
                    }
                    if(isset($layout['slider_speed'])){
                        $sc_param .=  HPLA::set_shortcode_param( 'autoplay-speed' , $layout['slider_speed'] );
                    }
                    $sc_param .=  HPLA::set_shortcode_param( 'categories' , $design_categories );
                    $sc_param .= HPLA::set_shortcode_param( 'layout', $layout['layout_type']);
                    echo do_shortcode("[design-listing $sc_param]");
                }
            ?>
            <?php $pcb->printFooter($elements['design_section_footer']); ?>
        </div>
    </div>
</section>