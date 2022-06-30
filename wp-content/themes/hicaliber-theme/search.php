<?php 
/**
 * The template for displaying search results pages
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */
 	
get_header(); ?>
			
	<section class="body-content">

		<div class="inner-body-content">	
            <div class="main-content">                           
                <div class="page-elements">
                	<div class="page-element search-result-listing content-box-element image-left-content split-25-75 grid default-grid-layout default-section default-alignment">
                		<div class="grid-container">
                		                  
							<div class="inner-content grid-x grid-padding-x">
					
								<main class="main cell" role="main">
									<header>
										<h1 class="archive-title"><?php _e( 'Search Results for:', 'jointswp' ); ?> <?php echo esc_attr(get_search_query()); ?></h1>
									</header>

									<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								 
										<!-- To see additional archive styles, visit the /parts directory -->
										<?php get_template_part( 'parts/loop', 'archive' ); ?>
									    
									<?php endwhile; ?>	

										<?php joints_page_navi(); ?>
										
									<?php else : ?>
									
										<?php get_template_part( 'parts/content', 'missing' ); ?>
											
								    <?php endif; ?>
						
							    </main> <!-- end #main -->
							
							</div> <!-- end #inner-content -->
						</div>
                	</div>                	
				</div>
			</div>
		</div>
		
	</section> 

<?php get_footer(); ?>