      <?php
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();

    $design = _get_sub_field_value('content_boxes_design'); 

    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'project-element', 'description', 'bg-helper', $design['section_classes'], $design['theme'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
        
    <?php echo $hs::design_background_image( $design['background_image'] ); ?> 

    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                
                <div class="cell small-12 hic-description product-item">
                    
                    <div class="inner-wrap">
                                                                            
                        <?php echo _get_field_value('ptc_content', $term)  ?>

                    </div>
                
            </div> 
            
            </div>
        </div>
    </div>
</section>