<?php
    $pcb = new hcContentBuilder();
    $hs = new hicaliber_theme_helpers;

    $content_boxes_display = _get_sub_field_value('cpts_features_layout');
    $design = _get_sub_field_value('cpts_features_design');
    $other_project = _get_field_value('proj_other_project');
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'project-element', 'feature-projects', 'content-boxes-1', 'content-boxes', $design['section_classes'], $design['theme'], $content_boxes_display['display'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    
    if( $other_project || $pcb->hasHeader( _get_sub_field_value('cpts_features_header') ) || $pcb->hasHeader( _get_field_value('proj_other_heading'), _get_field_value('proj_other_desc') ) ) : 
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>

    <div class="inner-section">
        <div class="grid-container">
            <?php 
                $heading_other = _get_field_value('proj_other_heading');
                $desc_other = _get_field_value('proj_other_desc');

                if($heading_other || $desc_other)
                    $pcb->printHeader($heading_other, $desc_other); 
                else
                    $pcb->printHeader(_get_sub_field_value('cpts_features_header')); 
            ?>

            <div class="grid-x grid-padding-x section-body <?php echo $content_boxes_display['layout_type']; ?>" data-item-col="<?php echo $content_boxes_display['per_row']; ?>" >
                
                <?php 
                    if( $other_project ) : 

                        foreach ($other_project as $project) :
                            $hicBox = "";
                            $hicBox = new hcPCBContent();
                            $hicBox->setTitle( $project['name'] );
                            $hicBox->setContent( $project['text'] );
                            $hicBox->setIcon( $project['icon'] );
                            $hicBox->setImage( new hcPCBLink($project['image']) );
                            
                            $hicBox->setClassesOf('hic-box-container', [ $content_boxes_display['per_row'] ]);
                            
                            $hicBox->displayContent();
                        endforeach;

                    endif; 
                ?>
            
            </div>
        </div>
    </div>
</section>

<?php endif; ?>