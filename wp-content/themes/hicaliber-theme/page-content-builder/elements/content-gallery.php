<?php

    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder(); 
    $gallery_helper = new HI_GALLERY_FUNCTION();

    $ligthbox_class = '';
	$post_type_class = '';
	$is_group_category = '';
	$is_image_above_content = '';
	
	$layout = $elements['pe_gallery_layout'];
	$content = $elements['pe_gallery_content'];
	
	$design = $elements['pe_gallery_design'];
	
	$is_post_type = $content['post_type'];
	$listing_type = $content['listing_type'];
	$manual_gallery = $content['gallery'];
	$listing_categorized = $content['is_category_group'];
	$categories = $content['categories'];
	$light_box = $content['pe_gallery_lightbox'];
	$selected_gallery = $content['selected_gallery'];
	$gallery_taxonomy = 'gallery_cat';
	
	$q = false;

    $evh = new hcElementController(  get_all_elements() );
	if(!$evh::isVisible('gallery', false, true)){
		$is_post_type =false;
	}
	if( $light_box ) {
	    $ligthbox_class = "with-lightbox";
	}
	
	if($is_post_type) {
		$post_type_class = 'is-post-type';
		$is_image_above_content = 'image-above-content'; 

		if($listing_categorized && $listing_type !== "select") {
			$is_group_category = 'is-group-by-category';
		}
		
		$counter = 0;
	}
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'gallery-element', $post_type_class, $is_group_category, $is_image_above_content, $layout['layout_type'], ($layout['layout_type'] == 'grid') ? $layout['display'] : '', $design['section_classes'] , $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '', $ligthbox_class ]
    );

     if($layout['slider_autoplay']) {        
        $set_data_autoplay = 'data-autoplay=1 data-autoplay-speed='.$layout['slider_speed'];    
    } else {
    	$set_data_autoplay = '';
    }
    if($is_post_type) {
		if(!$categories) {
			$categories = get_terms($gallery_taxonomy);
		}
			
		$args = array(
			'order' => 'ASC',
			'posts_per_page' => -1,
			'orderby' => 'ID',
			'post_type' => 'gallery',
			'post_status' => 'publish'
		);

		$terms = [];
		
		if( $categories ) {
			foreach($categories as $category) if($category->term_id) array_push($terms, $category->term_id);
			
			$args['tax_query'] = array(
				array(
					'taxonomy'  => $gallery_taxonomy,
					'field'     => 'id', 
					'terms'     => $terms,
					'operator' => 'IN'
				),
			);
		}
		if($listing_type=='featured') {
			
			$args['meta_query'] = array(
				array(
					'key'     => 'post_featured',
					'value'   => '1',
					'compare' => '='
				),
			);
		}
		if($listing_type=='select') {
			$args['post__in'] = $selected_gallery; 
			$listing_categorized = false;
		}
		
		if($listing_categorized && $listing_type =='featured') {
			
			$cat_args = array(
				'taxonomy' => $gallery_taxonomy,
				'hide_empty' => 0,
				'meta_key' => 'category_featured',
				'meta_value' => true
			);
			
			$categories = get_categories($cat_args);
		}

		$q = new WP_Query( $args );
	}

?>

<?php if( ($is_post_type ? $q->have_posts() : false ) || ( $manual_gallery && !$is_post_type) ) : ?>
<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>
	<div class="inner-section">
		<div class="grid-container">
			<?php $pcb->printHeader($elements['pe_gallery_header']); ?>
			
			<div class="grid-x grid-padding-x section-body" data-item-col="<?php echo $layout['per_row']; ?>" <?php echo $set_data_autoplay; ?>>
			    
			   <?php if(!$is_post_type) : ?>
			   
			     <?php foreach( $manual_gallery as $gallery ) : ?>
			   
			        <?php echo $gallery_helper->hi_set_gallery_html($layout['per_row'],$light_box,$gallery); ?>
			       
			      <?php  endforeach; ?>
			       
			   <?php else : ?>
			   
			        <?php if($listing_categorized && $categories) : ?>
			           
			            	<?php 
			            	        
			            	    
			            	    foreach( $categories as $category ) : 
			            	        
									if($category->term_id){
										$argss = array(
											'order' => 'ASC',
											'posts_per_page' => -1,
											'orderby' => 'ID',
											'post_type' => 'gallery',
											'post_status' => 'publish',
											'tax_query' => array(
												array(
													'taxonomy'  => $gallery_taxonomy,
													'field'     => 'id', 
													'terms'     => $category->term_id,
													'operator' => 'IN'
												),
											)
										);
										
									} 

										
									// Create the related query
									$contents = new WP_Query( $argss );
							        
								?>
								    
									<?php 
										
										if( $contents->have_posts())  : 
                                            $counter = 0;
										?>

    										<?php while( $contents->have_posts() ) :  $contents->the_post(); 
    										    
    										    $gallery = get_field('main_gallery');
    										    
    										    if($gallery) {
    										         $gallery_count = count($gallery);
    										         $counter += $gallery_count;
    										    }
    										    
    							        	?>

										<?php endwhile; ?>


										<?php endif; wp_reset_query(); ?>
										
										
										    <div class="cell <?php echo $layout['per_row']; ?>">
    			            
                    			               <div class="hic-box">
                    			                   
                    			                   <a href="<?php echo !$light_box ? get_term_link($category, $gallery_taxonomy) : "javascript:void(0);"; ?>" data-fancybox-trigger="gallery-<?php echo $category->slug; ?>" data-fancybox-index="0" >
                    			                   
                    			                   <div class="hic-image-container">
                                                                <div class="overlay"></div>
                                                                <div class="hic-image" style="background-image: url(<?php echo get_field('pc_featured_image', $category); ?>);"></div>
                                                            </div>
                            			                   
                            			                    <div class="hic-content">
                            			                        <div class="hic-title">
                            			                            <h3><?php echo $category->name; ?></h3>
                            			                        </div>
                            			                        <div class="hic-blurb">
                            			                            <?php
                            			                                echo $counter . ' Photos';
                            			                            ?>
                            			                           </div>
                            			                    </div>
                            			                    
                            			                    </a>
                            			                </div>
                                			              <?php
													         if($gallery && $light_box):
			    										         foreach($gallery as $g){
			    										         	printf("<a style='display:none;' href='%s' data-fancybox='gallery-%s'><img src='%s'></a>", $g["url"], $category->slug, $g["sizes"]["thumbnail"]);
			    										         }
			    										     endif;

                                			              ?>
                                			         </div>
									          
								
								<?php endforeach; ?>
			        
			        
			        <?php else : ?>
			        
			        <?php while( $q->have_posts() ) : $q->the_post(); 
    			    
    			        $title = get_the_title(); 
    			        $galleries = get_field('main_gallery');
    			        $link = get_permalink();
                        $gallery_elem_id = sanitize_title($title);
                        
                        $terms = get_the_terms(get_the_ID(), 'gallery_cat');
        			        
        			        if($galleries) {
        			            $featured_image = $galleries[0]['url'];
        			        }
        			        
        			        if(get_the_post_thumbnail_url(get_the_ID(),'full')) {
        			            $featured_image =  get_the_post_thumbnail_url(get_the_ID(),'full');
        			        }
    			       	
    			        ?>
    			        
    			        
    			        <div class="cell <?php echo $layout['per_row']; ?>">
    			            
			               <div class="hic-box">
			                   
			                   <a href="<?php echo !$light_box ? $link : "javascript:void(0);"; ?>" <?php echo $light_box ? "data-fancybox-trigger='gallery-{$gallery_elem_id}'" : ""; ?>>
			                   
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
			                        
			                        <?php if($galleries) : ?>
			                        <div class="hic-blurb">
			                            <?php
			                                 if($galleries) {
                        			            echo count($galleries) . ' Photos';
                        			        }
			                            ?>
			                           </div>
			                         <?php endif; ?>
			                         
			                    </div>
			                    </a>
			                </div>
			                <?php
						         if($galleries && $light_box):
							         foreach($galleries as $g){
							         	printf("<a style='display:none;' href='%s' data-fancybox='gallery-%s'><img src='%s'></a>", $g["url"], $gallery_elem_id, $g["sizes"]["thumbnail"]);
							         }
							     endif;
							?>
    			         </div>
    
    			    <?php endwhile; ?>  
    			
    			    
    			    <?php endif; wp_reset_query(); ?> 
			    
			    <?php endif;  ?> 
			    
			</div>
			
			<?php $pcb->printFooter($elements['pe_gallery_footer']); ?>  
		</div>
	</div>
</section>
<?php endif; ?>