<?php
/**
 * Displays archive pages if a speicifc template is not set. 
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); 

	$body_content_class = "";
	$sidebar_left = FALSE;
	$sidebar_right = FALSE;
	$sidebar_both = FALSE;

    $sidebar_options = get_field('post_sidebar','options'); 
	
	if($sidebar_options && $sidebar_options['post_cp_sidebar'] == 'has-sidebar-left' ) {
        $sidebar_left = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_cp_sidebar'];
    }
    if($sidebar_options && $sidebar_options['post_cp_sidebar'] == 'has-sidebar-right') {
        $sidebar_right = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_cp_sidebar'];
    }
    if($sidebar_options && $sidebar_options['post_cp_sidebar'] == 'has-sidebar-both') {
        $sidebar_both = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_cp_sidebar'];
    }

    $sidebar_left_widget = !empty($sidebar_options['cp_left_sidebar']) ? $sidebar_options['cp_left_sidebar'] : '';
    $sidebar_right_widget = !empty($sidebar_options['cp_right_sidebar']) ? $sidebar_options['cp_right_sidebar'] : 'sidebar2';
    
    $banner_options = get_field('pc_banner_option', 'options');

    $term = get_queried_object();


?>

<?php get_template_part('parts/content', 'hero-v2'); ?>
			
<section class="body-content<?php echo $body_content_class; ?>">

    <div class="inner-body-content">

	<?php if( $sidebar_left || $sidebar_both ) { get_sidebar($sidebar_left_widget); } ?>

		<div class="main-content">
                   
            <div class="page-elements">

            	<?php if( is_tag() && _have_rows('post_tag_element_builder', 'options')) : ?>
               
				            <?php
				          
				            while ( _have_rows('post_tag_element_builder', 'options') ) : the_row();
				                /**********************
				                Element Builder
				                ***********************/
				                if(get_row_layout() != 'global_element') {
				                   include( locate_template('post-module/content-tag-'.get_row_layout().'.php', false, false ) );
				                } 
				                
				            endwhile;
				            				           				        
				    ?> 


				   <?php else : ?>

				   	<?php if(is_tag()) : 

				   		$description = get_field('pc_main_content', $term);

				   		?>

				   		<?php if($description) : ?>

					   	<div class="page-element category-description pb-0">
					   		<div class="grid-container">
					   			<div class="grid-x grid-padding-x">
					   				<div class="cell">
					   					<?php echo $description; ?>
					   				</div>
					   			</div>
					   		</div>
					   		
					   	</div>

					   <?php endif; ?>

				   <?php endif; ?>

				   	<div class="page-element post-element">
                    			<div class="grid-container">

                    				<div class="grid-x grid-padding-x">
		
					    				<main class="main cell" role="main">
						    				
						    				<?php if( $banner_options['show_page_banner'] == FALSE && $banner_options['show_page_banner'] == FALSE): 
						    						
						    					?>	

						    					
										    	<header>
										    		<h1 class="page-title"><?php echo single_cat_title(); ?></h1>
													<?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
										    	</header>

										    	

									    	<?php endif; ?>
									
									    	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
										 
												<!-- To see additional archive styles, visit the /parts directory -->
												<?php get_template_part( 'parts/loop', 'archive' ); ?>
											    
											<?php endwhile; ?>	

												<?php joints_page_navi(); ?>
												
											<?php else : ?>
																		
												<?php get_template_part( 'parts/content', 'missing' ); ?>
													
											<?php endif; ?>
									
										</main> <!-- end #main -->
</div>
</div>
					</div>

                  <?php endif; ?>

                		  

				</div>								
	    
			</div> 

			<?php if( $sidebar_right || $sidebar_both ) { get_sidebar( $sidebar_right_widget ); } ?>
	    
		</div> 

</section>

<?php if( is_tag() && _have_rows('post_cat_element_builder', 'options')) : ?>
     
      
      	
                                  
				            <?php
				          
				            while ( _have_rows('post_cat_element_builder', 'options') ) : the_row();
				                /**********************
				                Element Builder
				                ***********************/
				                if(get_row_layout() == 'global_element') {				                	
				                   include( locate_template('post-module/content-tag-'.get_row_layout().'.php', false, false ) );
				                } 
				                
				            endwhile;
				            
				            

				        
				    ?> 
				    <?php endif; ?>



<?php get_footer(); ?>