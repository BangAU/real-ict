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

	<?php if ( have_posts() && '' !== get_post()->post_content ) : 
	
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
							<div class="page-element content-element">
								<div class="grid-container">
									<div class="grid-x grid-padding-x">
										<main class="cell" role="main">
								
											<?php while (have_posts()) : the_post(); ?>					    
									    	   	<section class="entry-content" itemprop="text">
												    <?php the_content(); ?>
												</section> <!-- end article section -->																										    
									   		 <?php endwhile; ?>	
								    	</main> <!-- end #main -->

									</div>
								</div>
							</div>													
						</div>
					</div>			   																		 			
					
					<?php if(get_field('page_sidebar')) : ?>	
						<?php get_sidebar('general'); ?>						
					<?php endif; ?>	  
									    
			
			</div>
		
		</section> <!-- end .body-content -->

	<?php endif; ?>

<?php get_footer(); ?>