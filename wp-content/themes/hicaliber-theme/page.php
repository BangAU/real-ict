<?php 
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 */

get_header();

//Banner
get_template_part('parts/content', 'hero-v2'); 
 ?>

	<?php if ( (have_posts() && '' !== get_post()->post_content && !_have_rows('page_content_builder') ) || (is_front_page() && _have_rows('page_content_builder') ) ) : 
	
         $classes = '';
        
          if(_get_field_value('page_sidebar')) {
                $classes .= 'has-sidebar';            
                $classes .= ' ' ._get_field_value('page_sidebar_location');            
            }

			
	?>
		<section class="body-content <?php echo $classes; ?>">
			<div class="inner-body-content">
					<?php echo child_menu(); ?>	
					<div class="main-content">
								
						<div class="page-elements">
							<?php if(have_posts() && '' !== get_post()->post_content && !_have_rows('page_content_builder') ) : while (have_posts()) : the_post(); ?>	
								<div class="page-element content-element">
									<div class="grid-container">
										<div class="grid-x grid-padding-x">
											<main class="cell" role="main">
												<section class="entry-content" itemprop="text">
													<?php the_content(); ?>
												</section> <!-- end article section -->		
											</main> <!-- end #main -->

										</div>
									</div>
								</div>
							<?php endwhile; endif; ?>
							<?php

							if( is_front_page() && _have_rows('page_content_builder') ) : 
								global $builder_index;
								$builder_index = 0;
						
								while ( _have_rows('page_content_builder') ) : the_row();
									
									/**********************
									 Column Builder
									***********************/
									if(get_row_layout() == "page_content"):
										
										$columns = _get_sub_field_value('columns');
										include( locate_template('page-content-builder/columns/content-'.$columns['column_type'].'.php', false, false ) );
										
									endif;
						
						
									/**********************
									 Element Builder
									***********************/
									if(get_row_layout() == "page_elements"):
										
										$elements = _get_sub_field_value('elements');  
										
										$evh = new hcElementController( get_all_elements() );
										if($evh::isVisible($elements['page_element_selection'], false, true) || $elements['page_element_selection'] == 'gallery') :
											
										include( locate_template('page-content-builder/elements/content-'.$elements['page_element_selection'].'.php', false, false ) );
										
										endif; 
									endif;
						
									$builder_index++;
									
								endwhile;
							endif;
							?>													
						</div>	
					</div>			   																		 			
					
					<?php if(get_field('page_sidebar')) : ?>	
						<?php get_sidebar('general'); ?>						
					<?php endif; ?>	  
									    
			
			</div>
		
		</section> <!-- end .body-content -->

	<?php endif; ?>

<?php get_footer(); ?>