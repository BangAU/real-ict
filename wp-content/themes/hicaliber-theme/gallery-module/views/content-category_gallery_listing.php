<?php
    
    $hs = new hicaliber_theme_helpers;
    $term = get_queried_object();
    
    $design = get_sub_field('category_gallery_listing_design');
    $layout = get_sub_field('category_gallery_listing_layout');
 
    
    $args = array(
		'order' => 'ASC',
		'posts_per_page' => -1,
		'orderby' => 'ID',
		'post_type' => 'gallery',
		'post_status' => 'publish',
	    'tax_query' => array(
			array(
				'taxonomy'  => 'gallery_cat',
				'field'     => 'id', 
				'terms'     => $term,
				'operator' => 'IN'
			),
		)
	);
   
    $q = new WP_Query( $args );

if( $q->have_posts()  ) : 
    
     $section_css = $hs::css_class_helper(
       [ 'page-element', 'category-gallery-listing', 'image-above-content', 'grid', $layout['display'], $design['section_classes'], $design['theme'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    
?>
<section class="<?php echo $section_css; ?>">
    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                
                <?php while( $q->have_posts() ) : $q->the_post(); 
    			    
    			         $title = get_the_title(); 
    			         $galleries = get_field('main_gallery');
    			        $link = get_permalink();

        			        
        			        if($galleries) {
        			            $featured_image = $galleries[0]['url'];
        			        }
        			        
        			        if(get_the_post_thumbnail_url(get_the_ID(),'full')) {
        			            $featured_image =  get_the_post_thumbnail_url(get_the_ID(),'full');
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