<?php
    $hs = new hicaliber_theme_helpers;

    $layout = $elements['pe_form_layout'];
    $design = $elements['contact_form_design'];
    $element_content = $elements['contact_form_content'];
    
    $has_map_class = "";
    $featured_images = "";
    
    $has_map = $element_content['show_map'] && $element_content['google_map'];
    
    if( $has_map && $layout != 'contact-layout-0' ) {
        $has_map_class = "has-map";
    }
    
    if( isset( $element_content['featured_image'] ) ) {
        $featured_images =  $element_content['featured_image'];
    }

    $tab_index = $element_content['contact_form_tab_index'] ? $element_content['contact_form_tab_index'] : 1;

    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'map-form-element', $layout, $design['theme'], $design['element_width'], $design['text_alignment'], $design['section_classes'], $design['background_image'] ? 'has-bg-img' : '', $has_map_class]
    );
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>" data-section-form>

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>

    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
            <?php if($layout != 'contact-layout-0' && $layout != 'contact-layout-4') : ?>


                <div class="cell medium-5 <?php echo ($element_content['contact_form_content_type'] == 'Contact Information') ? 'large-4' : ''; ?>" >
                    <div class="cnt-form">


                    <?php if(($element_content['contact_form_title'] || $element_content['sub_title']) || ($element_content['contact_form_content_type'] == 'Contact Information' && $layout != 'contact-layout-0' )) : ?>

                    <div class="section-header"> 

                            <div class="frm-title">
                                <h2 class="section-title"><?php echo $element_content['contact_form_title']; ?></h2>
                                <p class="sub-heading"><?php echo $element_content['sub_title']; ?></p>
                            </div>

                            <?php if($element_content['contact_form_content_type'] == 'Contact Information' && $layout != 'contact-layout-0' ) : ?>
                            <div class="frm-content form-contact">
                                <?php set_contact_info(); ?>
                                <?php set_social_media(); ?>
                            </div>
                            <?php else : ?>
                            <div class="form-blurb">
                                <?php echo $element_content['contact_form_blurb']; ?>
                            </div>
                            <?php endif; ?>
                    </div>

                    <?php endif; ?>
                        
                </div>
    
                </div>
        

                <div class="cell medium-7 <?php echo (($element_content['contact_form_content_type'] == 'Contact Information')) ? 'large-8'  : ''; ?>">

                <?php 
                        //getting form (populated with Gravity Form)
                        $mcf_form = $element_content['contact_forms_gf'];
                        if( isset($mcf_form['id']) ? $mcf_form['id'] : false ){
                            gravity_form_enqueue_scripts($mcf_form['id'], true);
                            gravity_form($mcf_form['id'], false, false, true, '', true, $tab_index); 
                        }
                ?>

                </div>

            <?php endif; ?>
                
            <?php if($elements['pe_form_layout'] == 'contact-layout-0' ) : ?>
                <div class="cell medium-6 pe-form-column">
                    <div class="frm-title text-center">
                        <h2 class="section-title"><?php echo $element_content['contact_form_title']; ?></h2>
                        <p class="sub-heading"><?php echo $element_content['sub_title']; ?></p>
                    </div>
                    <div class="form-blurb">
                        <?php echo $element_content['contact_form_blurb']; ?>
                    </div>
                    <?php 
                        //getting form (populated with Gravity Form)
                        $mcf_form = $element_content['contact_forms_gf'];
                        if( isset($mcf_form['id']) ? $mcf_form['id'] : false ){
                            gravity_form_enqueue_scripts($mcf_form['id'], true);
                            gravity_form($mcf_form['id'], false, false, true, '', true, $tab_index); 
                        }
                    ?>
                </div>
            <?php endif; ?>
                
            <?php if($elements['pe_form_layout'] == 'contact-layout-4' ) : ?>
                <div class="cell section-header">                    
                            <h2 class="section-title"><?php echo $element_content['contact_form_title']; ?></h2>
                            <?php if($element_content['sub_title']) : ?>
                                <h4 class="sub-heading"><?php echo $element_content['sub_title']; ?></h4>      
                            <?php endif; ?>                  
                </div>
                <?php if($element_content['contact_form_content_type'] == 'Contact Information') : ?>
                <div class="cell frm-content form-contact">
                    <?php set_contact_info(); ?>
                    <?php set_social_media(); ?>
                </div>
                <?php endif; ?>
                <?php if($element_content['contact_form_content_type'] == 'Blurb') : ?>
                    <div class="cell frm-content">
                        <div class="form-blurb">
                            <?php echo $element_content['contact_form_blurb']; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($has_map) : ?>
                <div class="cell medium-6">
                    <div id="sub_map" class="sub-page-map">
                            <div class="sub-map">
                                <?php echo $element_content['google_map']; ?>
                            </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="cell <?php echo ($has_map && $layout == 'contact-layout-4') || $layout != 'contact-layout-4' ?  'medium-6' : 'large-6' ?>">
                    <?php 
                            //getting form (populated with Gravity Form)
                            $mcf_form = $element_content['contact_forms_gf'];
                            if( isset($mcf_form['id']) ? $mcf_form['id'] : false ){
                                gravity_form_enqueue_scripts($mcf_form['id'], true);
                                gravity_form($mcf_form['id'], false, false, true, '', true, $tab_index); 
                            }
                        ?>
                </div>
            <?php endif; ?>
            <?php if( $featured_images && $layout == 'contact-layout-0' ) : ?>
                <div class="cell medium-6 form-featured-image">
                    <div class="bg-helper featured-image" style="background-image:url(<?php echo $featured_images ?>)"></div> 
                </div>
            <?php endif ?>
        </div>
    </div>
    
    <?php if( $has_map && $elements['pe_form_layout'] != 'contact-layout-0' && $elements['pe_form_layout'] != 'contact-layout-4' ) : ?>
        <div id="sub_map" class="sub-page-map">
                <div class="sub-map">
                    <?php echo $element_content['google_map']; ?>
                </div>
        </div>
    <?php endif; ?>
   </div>
   
</section>