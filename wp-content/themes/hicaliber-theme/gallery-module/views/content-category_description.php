<?php
    $hs = new hicaliber_theme_helpers;
    $galleries = get_field('main_gallery');
    $title = single_cat_title('', FALSE);
    $banner_options = get_field('gallery_cat_banner', 'options');
    
    $term = get_queried_object();
    
        
    
    $design = get_sub_field('content_boxes_design');
    $layout = get_sub_field('gallery_category_desc_layout');
    
    
    $featured_image = get_field('pc_featured_image', $term);
    $main_description = get_field('pc_main_content', $term); 
    
     $section_css = $hs::css_class_helper(
       [ 'page-element', 'category-gallery-description', $layout['display'], $design['section_classes'] , $design['theme'], $design['text_alignment'] ]
    );
    
?>
<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <div class="hic-box">
                        <?php if($layout['display'] != 'content-only') : ?>
                        <div class="hic-gallery">
                            <div class="overlay"></div>
                            <div class="hic-image" style="background-image: url(<?php echo $featured_image; ?>)"></div>
                        </div>
                        <?php endif; ?>
                        <div class="hic-content">
                            <?php if(!$banner_options['show_page_banner']) : ?>
                                <h1><?php echo $title; ?></h1>
                            <?php endif; ?>
                            <?php echo $main_description; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</section>