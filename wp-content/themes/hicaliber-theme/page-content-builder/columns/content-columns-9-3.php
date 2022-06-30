<?php 
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();
							
    $contents = $columns['cc_columns']; 
    $design = $columns['columns_design']; 
    $footer = $columns['columns_footer'];
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-columns',  'page-element', 'flexible-content', $columns['column_type'], 'bg-helper', $design['section_classes'], $design['theme'], $design['element_width'],$design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    
?>
<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
											
    
    <?php echo $hs::design_background_image( $design['background_image'] ); ?> 

    <div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($columns['columns_header']); ?>
            
            <div class="grid-x grid-padding-x section-body">
                <div class="cell medium-7 large-9">
                    <?php echo $contents['first_column']; ?>
                </div>
                <div class="cell medium-5 large-3">
                    <?php echo $contents['second_column'];  ?>
                </div>
            </div>
            
            <?php $pcb->printFooter($footer); ?>
        <div>
    </div>
   
</section>