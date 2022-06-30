<?php

    $cta = _get_field_value('proj_section');
    
    extract($cta);
    extract(_get_sub_field_value('cpts_cta_header')); 

    if( $hide_section ) :

        $hs = new hicaliber_theme_helpers;
        $pcb = new hcContentBuilder();

        $design = _get_sub_field_value('cpts_cta_design'); 
        $section_main_layout = _get_sub_field_value('cpts_cta_layout');  

        $section_css = "";

        $section_css = $hs::css_class_helper(
           [ 'page-element', 'project-element', 'section-cta', 'bg-helper', $design['section_classes'], $design['theme'], $section_main_layout['display'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
        );

?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?> 

    <div class="inner-section">
        <div class="grid-container">
            <?php
                
                if($cta['heading_text']) {
                    $pcb->printHeader($cta['heading_text']);
                } else {
                    $pcb->printHeader($peh_section_title);    
                }
            
                
            ?>
            <div class="grid-x grid-padding-x medium-row">
                <div class="cell bn-quote-2">
                    <?php if($content) : ?>
                    <div class="cta-blurb">
                        <?php _e($content); ?> 
                    </div>
                    <?php endif; ?>
                </div>

                <div class="cell main-button-container text-center">
                <?php
                if($call_to_action_button) :
                    foreach($call_to_action_button as $btn) :
                        extract($btn);
                        if($button_target == 'modal'){
                            $button = new hcPCBButtonElement($modal);
                            $button->toggleClass('secondary-button');
                            $button->displayButtonElement();
                        } else 
                            if($link){
                                $button = new hcPCBButtonElement($link);
                                $button->displayButtonElement();
                            }
                            
                    endforeach; 
                endif;
                ?>
                </div>
            </div>
        </div>
    </div>

</section>

<?php endif; ?>