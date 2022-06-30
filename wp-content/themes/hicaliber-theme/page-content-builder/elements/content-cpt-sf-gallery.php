<?php

    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder(); 
	
    $grid_layout = get_field('cpt_grid_layout');
    $display = get_field('display');
	$theme = get_field('theme');
	$width = get_field('element_width');
    $alignment = get_field('text_alignment');
    $section_class = get_field('section_classes');
    $per_row = get_field('per_row');
	
	$listing_categorized = get_field('cpt_gallery_categorized_items');
	$categories = get_field('cpt_gallery_categories');
	
    
    if(!$categories) {
        $categories = get_terms('gallery_cat');
    }
	
	$header = get_field('cpt_content_header');
	
	$counter = 0;
    
	$is_group_category = '';

	if($listing_categorized) {
		$is_group_category = 'is-group-by-category';
	}
    
    $section_css = "";
    
    $section_css = $hs::css_class_helper(
       [ 'page-element', 'gallery-element', 'is-post-type', $is_group_category, 'grid', $grid_layout, $display, $section_class, $theme, $width, $alignment ]
    );
    
    	
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
				'taxonomy'  => 'gallery_cat',
				'field'     => 'id', 
				'terms'     => $terms,
				'operator' => 'IN'
			),
		);
	}

	$q = new WP_Query( $args );
	
	
	function hi_set_gallery_html($layout , $light_box=FALSE, $image) {
	    
	    $html = '';
	    
	     $html .= '<div class="cell image-list '. $layout.'">';
		    if( $light_box ) :
				 $html .= '<a  href="'.$image['url'].'" title="'.$image['title'].'" data-caption="'.$image['title'].'" data-fancybox="gallery" data-thumb="'.$image['url'] .'">';
			endif;    
			
			
				 $html .= '<div class="hic-image" style="background-image: url('.$image['url'].')">';
				 
					
					if( $light_box ) : 
						 $html .= '<div class="cross-icon-wrap">';
							 $html .= '<img src="'.get_template_directory_uri() . '/assets/images/zoom-in.png" alt="zoom-icon">';								
						 $html .= '</div>';
					endif;
					

				$html .= '</div>';
			 if( $light_box ) :
				$html .= '</a>';
		    endif;
		$html .='</div>';
		
		return $html;
	}
	

?>

<?php if( $q->have_posts()  ) : ?>

<section <?php hi_set_pageid( get_field('section_id') ); ?> class="<?php echo $section_css; ?>">

    
	<div class="inner-section">
		<div class="grid-container">
			<?php $pcb->printHeader($header); ?>
			
			<div class="grid-x grid-padding-x section-body">
			    
			    
			    
			   
			        <?php 
			        
			        
			            if($listing_categorized && $categories) : ?>
			        
			       
			           
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
													'taxonomy'  => 'gallery_cat',
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
    										    
    										    $gallery_count = count(get_field('main_gallery'));
    										    
    										    $counter += $gallery_count;
    										    
    							        	?>

										<?php endwhile; ?>


										<?php endif; wp_reset_query(); ?>
										
										
										    <div class="cell <?php echo $per_row; ?>">
    			            
                    			               <div class="hic-box">
                    			                   
                    			                   <a href="<?php echo get_term_link($category, 'gallery_cat'); ?>">
                    			                   
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
                            			                </div>
                                			            
                                			         </div>
									            </a>
								
								<?php endforeach; ?>
			        
			        
			        <?php else : ?>
			        
			        <?php while( $q->have_posts() ) : $q->the_post(); 
    			    
    			         $title = get_the_title(); 
    			         $terms = get_the_terms(get_the_ID(), 'gallery_cat');
    			        $galleries = get_field('main_gallery');
    			        $link = get_permalink();
        
        			        
        			        if($galleries) {
        			            $featured_image = $galleries[0]['url'];
        			        }
        			        
        			        if(get_the_post_thumbnail_url(get_the_ID(),'full')) {
        			            $featured_image =  get_the_post_thumbnail_url(get_the_ID(),'full');
        			        }
    			       
    			        
    			        ?>
    			        
    			        
    			        <div class="cell <?php echo $per_row; ?>">
    			            
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
    			            
    			         </div>
    
    			    <?php endwhile; ?>  
    			
    			    
    			    <?php endif; wp_reset_query(); ?> 
			    
		
			    
			</div>

		</div>
	</div>
</section>
<?php endif; ?>