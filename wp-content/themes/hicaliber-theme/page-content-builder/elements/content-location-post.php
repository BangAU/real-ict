<?php

    $hs = new hicaliber_theme_helpers;

    $pcb = new hcContentBuilder(); 

    $layout = $elements['pe_posts_layout'];
    
    $design = $elements['pe_posts_design'];
    
    $content_options = $elements['pe_posts_content'];
    
    $posts_per_page = $content_options['quantity'] ? $content_options['quantity'] :     -1;
    $exclude = array();
    if(isset($content_options['exclude']) ? $content_options['exclude'] : false) $exclude[] = $content_options['exclude'];


    $args = array(
        'post_type'             => 'location_post',
        'posts_per_page'        => $posts_per_page,
        'post_status'           => 'publish',
    );

    if( $content_options['location'] ) {
        $args['meta_key']   = 'link_to_location';
        $args['meta_value'] = $content_options['location'];
    } else {
        $args['order'] = 'DESC';
        $args['orderby'] = 'date'; 
    }
    
    if(is_singular('location_post')){
        $args['post__not_in'] = array(get_the_ID());
    }

    if(!empty($exclude)){
        $args['post__not_in'] = $exclude; 
    }
    
    $q = new WP_Query( $args );
        
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'location-post-element', 'post-element', $layout['display'], $design['section_classes'], $layout['layout_type'], ($layout['layout_type'] =='grid') ? $layout['grid_layout']: '', $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

    if($layout['slider_autoplay']) {        
        $set_data_autoplay = 'data-autoplay=1 data-autoplay-speed='.$layout['slider_speed'];    
    } else {
        $set_data_autoplay = '';
    }
    


?>
<?php if( $q->have_posts() ) : ?>
<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>
	<div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($elements['pe_posts_header']); ?>
                    
            <div class="grid-x grid-padding-x section-body" data-item-col="<?php echo $layout['per_row']; ?>" <?php echo $set_data_autoplay; ?>>
            
            <?php  while( $q->have_posts() ) : $q->the_post(); 
                    
                    $hicArticle = new hcPCBArticle();
                    $hicArticle->setClassesOf('hic-box-container', ['hic-item',$layout['per_row']]);
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
                    
                    $hicArticle->setMetaOption($content_options['single_location_post_meta_options']);                        
                        
                    $button = new hcPCBButtonElement();
                    $button->constructButton(get_the_permalink(), "Read more");
                    
                    $hicArticle->setButton($button);
                    if(get_field('post_featured')) {
                        $hicArticle->setClassesOf('hic-box', [ 'is-featured' ]);
                    }
                    
                    $hicArticle->displayContent();
                    
                endwhile; ?>
                
            </div>   
            <?php $pcb->printFooter($elements['pe_posts_footer']); ?>
        </div>
	</div>
</section>
<?php endif; wp_reset_postdata(); ?>