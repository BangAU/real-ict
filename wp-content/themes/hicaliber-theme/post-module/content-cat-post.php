<?php

    $hs = new hicaliber_theme_helpers;

    $pcb = new hcContentBuilder(); 

    $layout = get_sub_field('cpts_post_list_layout');
    
    $design = get_sub_field('content_boxes_design');
    
    $content_options = get_sub_field('cpts_post_list_option');
    
    $posts_per_page = $content_options['op_property_to_show'] ? $content_options['op_property_to_show'] : 9;

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    
    
    $args = array(
        'post_type'             => 'post',
        'post_status'           => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged
    );
    
    
        $args['category__in'] = $term;

    
    if( $content_options['featured_post'] ) {
        $args['meta_key']   = 'post_featured';
        $args['meta_value'] = 1;
    } else {
        $args['order'] = 'DESC';
        $args['orderby'] = 'date'; 
    }
    
    $q = new WP_Query( $args );
        
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'post-element', 'listing-element', $layout['display'], 'grid', $layout['grid_layout'], $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

    // if($layout['slider_autoplay']) {        
    //     $set_data_autoplay = 'data-autoplay=1 data-autoplay-speed='.$layout['slider_speed'];    
    // } else {
    //     $set_data_autoplay = '';
    // }
    


?>
<?php if( $q->have_posts() ) : ?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>
	<div class="inner-section">
        <div class="grid-container">

            <?php //$pcb->printHeader($elements['pe_posts_header']); ?>
                    
            <div class="grid-x grid-padding-x section-body" data-item-col="<?php echo $layout['per_row']; ?>" <?php // echo $set_data_autoplay; ?>>
            
            <?php  while( $q->have_posts() ) : $q->the_post(); 
                    
                    $hicArticle = new hcPCBArticle();
                    $hicArticle->setTitle(get_the_title());
                    
                    $content = wp_trim_words(get_the_content(), 20, '...');
                    
                    if(has_excerpt()) {
                        $content = get_the_excerpt();
                    }
                    
                    $hicArticle->setContent($content);
                    $hicArticle->setImage(new hcPCBLink(get_featured_image( get_the_ID() )));
                    
                    // if(is_array($post_meta_options))
                    // if(in_array('date', $post_meta_options))
                    //     $hicArticle->setDate( get_the_date() );
                    
                    $hicArticle->setMetaOption($content_options['post_meta_options']);                        
                        
                    $button = new hcPCBButtonElement();
                    $button->constructButton(get_the_permalink(), "Read more");
                    
                    $hicArticle->setButton($button);
                    $hicArticle->setClassesOf('hic-box-container', ['hic-item',$layout['per_row']]);
                    if(get_field('post_featured')) {
                        $hicArticle->setClassesOf('hic-box', [ 'is-featured' ]);
                    }
                    
                    $hicArticle->displayContent();
                    
                endwhile; ?>
                
            </div>   
            
            <?php 
                /*************************
                * PAGINATION
                *************************/
                //   if( isset( $q['pager'] ) ) {
                //     echo "<div class='cell pager-column'><div class='wp-pager'>".$q['pager']."</div></div>";
                //   } 
            ?>
            
            <?php
            if($q->found_posts > $posts_per_page) : ?>
                <div class="grid-x grid-padding-x section-footer">
                    <div class="cell">
                        <?php joints_page_navi(); ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
	</div>
</section>

<?php endif; wp_reset_postdata(); ?>