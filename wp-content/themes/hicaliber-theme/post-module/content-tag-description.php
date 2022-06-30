      <?php
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();

    $design = _get_sub_field_value('content_boxes_design'); 

    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'post-element', 'description', 'bg-helper', $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    
    $description = get_field('pc_main_content', $term);

    $banner_option = _get_field_value('post_single_banner_options', 'options');
?>

<?php if($description) : ?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
        
    <?php echo $hs::design_background_image( $design['background_image'] ); ?> 

    <div class="inner-section">
        <div class="grid-container">
            <?php if( !$banner_option['show_page_banner'] ): ?>	
                <div class="grid-x grid-padding-x page-header">
                    <div class="cell">
        		    	<header>
        		    		<h1 class="page-title"><?php echo single_cat_title(); ?></h1>
        					<?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
        		    	</header>
    		    	</div>
                </div>
	    	<?php endif; ?>
            <div class="grid-x grid-padding-x">
                
                <div class="cell small-12 hic-description product-item">
                    
                    <div class="inner-wrap">                        
                                                                                
                        <?php echo tag_description();  ?>

                    </div>
                
            </div> 
            
            </div>
        </div>
    </div>
</section>

<?php endif; ?>