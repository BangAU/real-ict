<?php
    
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder(); 
    
    $gallery_id = get_the_ID();
    
    $layout = get_sub_field('cpts_related_layout');
    $section_header = get_sub_field('cpts_related_header');
    $design = get_sub_field('related_design');
    
    if($layout['slider_autoplay']) {        
        $set_data_autoplay = 'data-autoplay=1 data-autoplay-speed='.$layout['slider_speed'];    
    } else {
    	$set_data_autoplay = '';
    }
    
    $args = array(
		'order' => 'ASC',
		'posts_per_page' => -1,
		'orderby' => 'ID',
		'post_type' => 'gallery',
		'post_status' => 'publish',
		'post__not_in' => array($gallery_id),
	   
	);
	
	$terms = get_the_terms($gallery_id, 'gallery_cat');
    
    if($terms) {
        
        $categories = [];
        
        foreach($terms as $term) {
           $categories[]  = $term->term_id;
        }
        
    	$args['tax_query'] = array(
			array(
				'taxonomy'  => 'gallery_cat',
				'field'     => 'id', 
				'terms'     =>  $categories,
				'operator' => 'IN'
			),
		);
        
    }
	
    $q = new WP_Query( $args );

if( $q->have_posts()  ) : 
    
     $section_css = $hs::css_class_helper(
       [ 'page-element', 'related-gallery', 'image-above-content', $layout['layout_type'], $layout['display'], $design['section_classes'], $design['theme'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    
?>
<section class="<?php echo $section_css; ?>">
    <div class="inner-section">
        <div class="grid-container">
            
            <?php $pcb->printHeader($section_header); ?>
            
            <div class="grid-x grid-padding-x section-body" data-item-col="<?php echo $layout['per_row']; ?>" <?php echo $set_data_autoplay; ?>>
                
                <?php while( $q->have_posts() ) : $q->the_post(); 
    			    
    			     $title = get_the_title(); 
    			     $galleries = get_field('main_gallery');
    			     $link = get_permalink();
    			     $id = get_the_ID();
    			        
    			     $terms = get_the_terms($id, 'gallery_cat');

        			        
			        if($galleries) {
			            $featured_image = $galleries[0]['url'];
			        }
			        
			        if(get_the_post_thumbnail_url($id,'full')) {
			            $featured_image =  get_the_post_thumbnail_url($id,'full');
			        }
    			       
    			        
    			        ?>
    			        
    			        
    			        <div class="cell <?php echo $layout['per_row']; ?>">
    			            
			               <div class="hic-box">
			                   
			                   <a href="<?php echo  $link; ?>">
			                   
			                   <div class="hic-image-container">
                                    <div class="overlay"></div>
                                    <div class="hic-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
                                </div>
			                   
			                    <div class="hic-content">
			                        <div class="hic-title">
			                            <h3><?php echo $title; ?></h3>
			                        </div>
			                          <?php if($terms) : ?>
			                        
			                        
			                             <div class="hic-category">
    			                            
    			                            
    			                                <?php
    			                                
    			                                $category = [];
    			                                
    			                                foreach($terms as $term) {
    			                                    
    			                                    $category[] = $term->name;
    			                                    
    			                                }
    			                                
    			                                echo implode(', ', $category);
    			                                
    			                                ?>
    			                                
    			                                
    			                            
    			                        </div>
			                        <?php endif; ?>
			                        <div class="hic-blurb">
			                            <?php
			                                 if($galleries) {
                        			            echo count($galleries) . ' Photos';
                        			        }
			                            ?>
			                           </div>
			                    </div>
			                    </a>
			                </div>
    			            
    			         </div>
    
    			    <?php endwhile; wp_reset_query();?>  
    			
    	
            </div>
        </div> 
    </div>
</section>
<?php endif; ?>