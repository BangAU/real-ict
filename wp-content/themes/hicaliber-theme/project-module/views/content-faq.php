<?php
    $hs = new hicaliber_theme_helpers; 
	$pcb = new hcContentBuilder();

	$design = _get_sub_field_value('cpts_faq_design');

	$faq_heading = _get_field_value('proj_faq_heading');
	$faq_sub_heading = _get_field_value('proj_faq_desc');
	
	$contents = _get_field_value('proj_faq_contents');
	$categories = $contents['categories'];
	
	$section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'project-element', 'project-faq', 'faq-section', 'bg-helper', $design['section_classes'], $design['theme'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

    if( $pcb->hasHeader($faq_heading, $faq_sub_heading) || $pcb->hasHeader(_get_sub_field_value('cpts_faq_header')) || _have_rows('proj_faq_contents')) :
	
	if( !is_array($categories) ) {
		$categories = get_terms( 'faq_cat', array('hide_empty' => 0, 'parent' =>0) );
	}
	if( $categories ) $no_tab = count($categories) > 1 ? false : true;
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

	<?php echo $hs::design_background_image( $design['background_image'] ); ?>

	<div class="inner-section">
		<div class="grid-container">
			<?php
				if( $faq_heading || $faq_sub_heading ) 
					$pcb->printHeader($faq_heading, $faq_sub_heading);
				else
					$pcb->printHeader(_get_sub_field_value('cpts_faq_header')); 
			?>
			<div class="grid-x grid-padding-">
				<?php if($contents['categorized_items'] && !$no_tab): ?>
				<div class="cell">
					<div class="main-button-container faq-tab-group text-center">
						<ul class="menu tab-slider">
						<?php foreach( $categories as $category ) : ?>
							<li>
							<?php
								if($category->name || $category->term_id){
									
									$btn = [
									'url'          => '',
									'title'        => $category->name,
									'target'       => '#faq-'.$category->term_id
									];
			
									$button = new hcPCBButtonElement($btn);
									$button->setID('faqbtn-'.$category->term_id);
									$button->displayButtonElement();
								}
							?> 
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
					
					<div class="tab-content-wrapper tab-content-slider <?php echo $no_tab ? 'no-tab' : '';?>">
					<?php foreach( $categories as $category ) : 
						if($category->term_id){
							$args = array(
								'order' => 'ASC',
								'orderby' => 'ID',
								'post_type' => 'faq',
								'post_status' => 'publish',
								'tax_query' => array(
									array(
										'taxonomy'  => 'faq_cat',
										'field'     => 'id', 
										'terms'     => $category->term_id,
										'operator' => 'IN'
									),
								)
							);
						} else {
							$args = array(
							'order' => 'ASC',
							'orderby' => 'ID',
							'post_type' => 'faq',
							'post_status' => 'publish'
							);
						}
							
						// Create the related query
						$contents = new WP_Query( $args );
					?>
								
						<ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false" id="<?php echo 'faq-'.$category->term_id; ?>">
							<?php 
								if( $contents->have_posts())  :
									while( $contents->have_posts() ) :  $contents->the_post(); 
							?>
							
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title"><?php echo get_the_title(); ?></a>
								<div class="accordion-content" data-tab-content><?php echo wpautop( get_the_content() ); ?></div>
							</li>
							
							<?php 
									endwhile; 
								else : 
							?>   
						
							<h5 class="text-center accordion-message-container">Sorry, there are currently no content to display.</h5>
							
							<?php endif; wp_reset_query(); ?>
						</ul>
					<?php endforeach; ?>
					</div> 
				</div>
				<?php else : ?>
				<div class="cell">
					<?php   
						$args = array(
							'order' => 'ASC',
							'orderby' => 'ID',
							'post_type' => 'faq',
							'post_status' => 'publish'
						);

						$terms = [];
						foreach($categories as $category) if($category->term_id) array_push($terms, $category->term_id);

						if( $categories ) {
							$args['tax_query'] = array(
								array(
									'taxonomy'  => 'faq_cat',
									'field'     => 'id', 
									'terms'     => $terms,
									'operator' => 'IN'
								),
							);
						}
					
						// Create the related query
						$contents = new WP_Query( $args );
					?>
						
					<ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">
						<?php 
							if( $contents->have_posts())  :
								while( $contents->have_posts() ) :  $contents->the_post(); 
						?>
						
						<li class="accordion-item" data-accordion-item>
							<a href="#" class="accordion-title"><?php echo get_the_title(); ?></a>
							<div class="accordion-content" data-tab-content><?php echo wpautop( get_the_content() ); ?></div>
						</li>
						
						<?php 
								endwhile; 
							else : 
						?>   
					
						<h5 class="text-center accordion-message-container">Sorry, there are currently no content to display.</h5>
						
						<?php endif; wp_reset_query(); ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php endif; ?>