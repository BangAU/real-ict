<?php
    global $post;

    $page_id = $post->ID;

    if( is_home() ) {
        $page_id = get_option( 'page_for_posts' );
    }

    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();

    $design = _get_sub_field_value('cpts_desc_gallery_design'); 
    $section_main_layout = _get_sub_field_value('cpts_desc_gallery_layout');  

    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'project-element', 'description-gallery', 'bg-helper', $design['section_classes'], $design['theme'], $section_main_layout['display'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
        
    <?php echo $hs::design_background_image( $design['background_image'] ); ?> 

    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell small-12 large-6 hic-description project-item">
                    <?php if(!_get_field_value('show_page_banner', $page_id)): ?>
                    <h1><?php echo get_the_title(); ?></h1>
                    <?php endif; ?>
                    <?php echo wpautop( get_the_content() ); ?>
                    
                    <?php 
                        echo $pv::buttons( $proj_actions_main );
                    ?>
                </div>
                <?php if( (is_array($image_gallery) ? count($image_gallery) > 0 : false) || (isset($video['youtube_video']) ? ($video['youtube_video'] ? true : false) : false) ):
                ?>            
                <div class="cell small-12 large-6 hic-gallery">
                    <?php 
                        $gallery_options = _get_sub_field_value('cpts_desc_gallery_settings');
                    echo $pv::gallery( $image_gallery , $video, $gallery_options ); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>