<?php 
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();
					
    $design = $elements['page_content_design']; 
    
    $section_css = "";

     $section_css = $hs::css_class_helper(
       [ 'page-element', 'page-content-element', $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
	

	<?php echo $hs::design_background_image( $design['background_image'] ); ?>

	<div class="inner-section">
		<div class="grid-container">
			<?php $pcb->printHeader($elements['page_content_header']); ?>

			<?php if( $post->post_content != "" ) : ?>
			<div class="grid-x grid-padding-x section-body">
				<div class="cell">
					<div class="page-content-container">
				
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php the_content(); ?>
							
							<?php endwhile; endif; ?>	

					</div>			
				</div>		
			</div>	
												
			<?php endif; ?>
			<?php $pcb->printFooter($elements['page_content_footer']); ?>
		</div>
	</div>
</section>