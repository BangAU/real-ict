<?php
    $hs = new hicaliber_theme_helpers;
    $galleries = get_field('main_gallery');
    $title = get_the_title();
    $design = get_sub_field('cpts_desc_gallery_design');
    
    $banner_options = get_field('gallery_single_page_banner', 'options');

    $layout = get_sub_field('gallery_layout');

    $display = 'default-layout';

    if($layout['gallery_type'] == 'grid') {
        $display = $layout['grid_display'];
    } else {
        $display = $layout['display'];
    }


    $light_box = isset($layout['lightbox']) ? $layout['lightbox'] : '';
    $ligthbox_class = '';
    if( $light_box ) {
        $ligthbox_class = "with-lightbox";
    }
    
     $section_css = $hs::css_class_helper(
       [ 'page-element', 'gallery-element', 'gallery-description', $layout['gallery_type'], $display, $design['section_classes'] , $design['theme'], $design['text_alignment'], $ligthbox_class ]
    );
    
?>
<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
    <div class="inner-section">
       
        <div class="grid-container">
            <div class="grid-x">

                <div class="cell gallery-container">
                    
             

                <div class="hic-gallery">

                            <div class="grid-container">
                                <div class="grid-x grid-padding-x gallery-slider">
                                                                    
                                        <?php foreach( $galleries as $gallery ) : 

                                               $title = isset($gallery['title']) ? $gallery['title'] : '';
                                               $caption = isset($gallery['caption']) ? $gallery['caption'] : '';


                                            ?>
                                            <div class="image-list cell <?php echo $layout['per_row']; ?>">

                                                <?php if($light_box) : ?>
                                                <a href="<?php echo $gallery['url']; ?>" title="<?php echo $title; ?>" data-caption="<?php echo $caption; ?>" data-fancybox="gallery1" data-thumb="<?php echo $gallery['url']; ?>">

                                                <?php endif; ?>

                                                <div class="hic-image" style="background-image: url(<?php echo $gallery['url']; ?>)">
                                                        
                         <?php if($light_box) : ?>
                             <div class="cross-icon-wrap">
                                <img src=" <?php echo get_template_directory_uri() . '/assets/images/zoom-in.png'; ?>" alt="zoom-icon">                             
                        </div>
                        <?php endif; ?>

                                                </div>
                                                <?php if($light_box) : ?>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                            
                                        <?php  endforeach; ?>
                                                                        
                                </div>
                                <?php 
                                    if($layout['gallery_type'] == 'carousel' && $layout['thumbnails']) :
                                 ?>
                                     <div class="grid-x grid-padding-x">
                                       <div class="cell">
                                            <div class="gallery-thumb-slider">
                                                <?php foreach( $galleries as $gallery ) : ?>
                                                    <div class="image-list">
                                                            <div class="hic-image" style="background-image: url(<?php echo $gallery['url']; ?>)"></div>
                                                    </div>
                                                
                                                <?php  endforeach; ?>
                                            </div>                                       
                                       </div>
                                    </div>  
                                     <?php endif; ?>
                            </div>

                            
                        </div>

                        <div class="gallery-content hic-content">

                             <div class="grid-container">          
             <div class="grid-x grid-padding-x">
                <div class="cell">
                    
               
                                                
                            <?php while (have_posts()) : the_post(); ?>                                                                   
                                <?php the_content(); ?>
                                                                                                                                                
                            <?php endwhile; ?> 

                            </div>
                        </div>

                        </div>

                        </div>


            </div>
        </div>

           </div>
        
             
                        
                 
           
            </div>
        </div> 
    </div>
</section>