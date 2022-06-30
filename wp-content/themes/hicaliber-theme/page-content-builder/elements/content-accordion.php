<?php
    $hs = new hicaliber_theme_helpers; 
	$pcb = new hcContentBuilder();

	$design = $elements['pe_faq_design'];
    $layout = $elements['pe_faq_layout'];

	$contents = $elements['pe_faq_content'];

	$categories = $contents['categories'];
	$featured_image = $contents['image'];
	
	$section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'accordion-element', $layout, $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    if( !is_array($categories) && $contents['categorized_items']) {
  		$categories = get_terms( 'faq_cat', array('hide_empty' => 0, 'parent' =>0) );
	}
	if( $categories ) $no_tab = count($categories) > 1 ? false : true;

	
	$args = array(
		'order' => 'ASC',
		'orderby' => 'ID',
		'post_type' => 'faq',
		'post_status' => 'publish'
	);

	$terms = [];
	
	if( $categories ) {
		foreach($categories as $category) if($category->term_id) array_push($terms, $category->term_id);
		
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
	$q = new WP_Query( $args );

?>

<?php if( $q->have_posts())  : ?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

	<?php echo $hs::design_background_image( $design['background_image'] ); ?>

	<div class="inner-section">
		<div class="grid-container">    

			<?php $pcb->printHeader($elements['pe_faq_header']); ?>
			
			<div class="grid-x grid-padding-x section-body">
				
				<?php if($featured_image): ?>				
					<div class="cell feature-image">
						<div class="hic-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
					</div>				
				<?php endif; ?>

				<?php if(($contents['categorized_items'] && !$no_tab) && $contents['faq_post_type']): 
					$counter = 0;
					$counter_2 = 0;
				?>
					<div class="cell accordion-container">						
						<ul class="tabs" data-tabs id="example-tabs">
							<?php foreach( $categories as $category ) : 
								$counter++;
							?>							
						  		<li class="tabs-title"><a href="#panel-<?php echo $counter; ?>" aria-selected="true"><?php echo $category->name; ?></a></li>						  		
							<?php endforeach; ?>
						</ul>

						<div class="tabs-content" data-tabs-content="example-tabs">
							
							
							<?php foreach( $categories as $category ) : 
									$counter_2++;
									if($category->term_id){
										$argss = array(
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
									} 

									$cat = $category->name;
									$cat = str_replace(' ', '-', $cat);
										
									// Create the related query
									$contents = new WP_Query( $argss );
								?>
											
									<div class="tabs-panel" id="panel-<?php echo $counter_2; ?>">
										<?php 
											if( $contents->have_posts())  : 

												?>

												<ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">
												<?php while( $contents->have_posts() ) :  $contents->the_post(); 
												

										?>
										
																
											<li class="accordion-item" data-accordion-item>
												<a href="#" class="accordion-title"><?php echo get_the_title(); ?></a>
												<div class="accordion-content" data-tab-content><?php echo wpautop( get_the_content() ); ?></div>
											</li>							
																
									
										
										<?php 
												endwhile; ?>

												</ul>
										
										
										<?php endif; wp_reset_query(); ?>
									</div>
								<?php endforeach; ?>

						</div>
					</div>
					
				<?php else : ?>			
					<div class="cell accordion-container">	
						<?php if($contents['faq_post_type']) : ?>					
						<ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">
							<?php while( $q->have_posts() ) :  $q->the_post(); ?>						
								<li class="accordion-item" data-accordion-item>
									<a href="#" class="accordion-title"><?php echo get_the_title(); ?></a>
									<div class="accordion-content" data-tab-content><?php echo wpautop( get_the_content() ); ?></div>
								</li>							
							<?php endwhile; ?>   									
						</ul>
						<?php else : ?>	


							<?php if( $contents['accordions'] ): ?>

								<ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">

								<?php foreach($contents['accordions'] as $accordion) :

									?>

									<li class="accordion-item" data-accordion-item>
									<a href="#" class="accordion-title"><?php echo $accordion['title']; ?></a>
										<div class="accordion-content" data-tab-content><?php echo $accordion['description']; ?></div>
									</li>	

								<?php endforeach; ?>

								</ul>

							<?php endif; ?>  									
						
						<?php endif; ?>
					</div>		
				<?php endif; ?>		
			</div>
		</div>
	</div>
</section>
<?php endif; wp_reset_query();?>