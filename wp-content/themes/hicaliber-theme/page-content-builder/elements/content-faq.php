<?php
    $hs = new hicaliber_theme_helpers; 
	$pcb = new hcContentBuilder();

	$design = $elements['pe_faq_design'];
    $layout = $elements['pe_faq_layout'];

	$contents = $elements['pe_faq_content'];

	$categories = $contents['categories'];
	$featured_image = $contents['image'];
	
	$first_item_open = isset($contents['first_item_open']) ? $contents['first_item_open'] : false; 
	$all_closed = isset($contents['all_closed']) ? $contents['all_closed'] : true; 
	$multi_expand = isset($contents['multi_expand']) ? $contents['multi_expand'] : false; 

	$section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'accordion-element', $layout, $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
    if( !is_array($categories) && $contents['categorized_items']) {
  		$categories = get_terms( 'faq_cat', array('hide_empty' => 0, 'parent' =>0) );
	}
	if( $categories ) $no_tab = count($categories) > 1 ? false : true;
	else $no_tab = true;

	if($layout == "two-column-accordion" && !$contents['faq_post_type'] ){
		if(is_array($contents['accordions'])){
			$total = count($contents['accordions']);
			$col_max_length = ceil( $total / 2);
			
			$contents['accordions2'] = array_slice($contents['accordions'], $col_max_length, $total - 1);
			$contents['accordions'] = array_slice($contents['accordions'], 0, $col_max_length);
		}
	} 

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'faq',
		'post_status' => 'publish'
	);

	if(isset($contents['order_by'])){
	    $order = isset($contents['order']) ? ($contents['order'] == 'desc' ? 'DESC' : 'ASC') : 'ASC'; 
	    
	    switch($contents['order_by']){
	        case 'title' : 
	            $args['order'] = $order;
	            $args['orderby'] = 'title';
            break;
            case 'date' : 
	            $args['order'] = $order;
	            $args['orderby'] = 'publish_date';
            break;
	        default:
	            $args['order'] = 'ASC';
	            $args['orderby'] = 'ID';
	        break;
	    }
	}

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
	
	if($layout == "two-column-accordion" && $contents['faq_post_type'] ){
		$current_row = 0;
		$total = $q->post_count;
		$col_max_length = ceil( $total / 2);
	}
?>

<?php if( ( $contents['faq_post_type'] && $q->have_posts() ) || $contents['accordions'] )  : ?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

	<?php echo $hs::design_background_image( $design['background_image'] ); ?>

	<div class="inner-section">
		<div class="grid-container">    

			<?php $pcb->printHeader($elements['pe_faq_header']); ?>
			
			<div class="grid-x grid-padding-x section-body">
				
				<?php if($featured_image && ($layout == 'image-left-accordion' || $layout == 'image-right-accordion') ): ?>				
					<div class="cell feature-image">
						<div class="hic-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>
					</div>				
				<?php endif; ?>
				
				<?php if($contents['content'] && ($layout == 'content-left-accordion' || $layout == 'content-right-accordion') ): ?>				
					<div class="cell hic-content">
						<?php echo $contents['content']; ?>
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
						  		<li class="tabs-title <?php echo ($counter == 1) ? ' is-active': ''; ?>"><a href="#panel-<?php echo $counter; ?>" aria-selected="true"><?php echo $category->name; ?></a></li>						  		
							<?php endforeach; ?>
						</ul>

						<div class="tabs-content" data-tabs-content="example-tabs">
							
							
							<?php foreach( $categories as $category ) : 
									$counter_2++;
									if($category->term_id){
										$argss = array(
											'order' => 'ASC',
											'posts_per_page' => -1,
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
											
									<div class="tabs-panel<?php echo ($counter_2 == 1) ? ' is-active': ''; ?>" id="panel-<?php echo $counter_2; ?>">
										<?php 
											if( $contents->have_posts())  : $fio_counter = 0;

												?>

												<ul class="accordion" data-accordion data-allow-all-closed="<?php echo $all_closed ? "true": "false"; ?>" data-multi-expand="<?php echo $multi_expand ? "true": "false"; ?>">
												<?php while( $contents->have_posts() ) :  $contents->the_post(); ++$fio_counter;
												

										?>
										
																
											<li class="accordion-item<?php echo $first_item_open && $fio_counter == 1 ? " is-active" : ""; ?>" data-accordion-item>
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
						<?php if($contents['faq_post_type']) : $fio_counter = 0; ?>					
						<ul class="accordion" data-accordion data-allow-all-closed="<?php echo $all_closed ? "true": "false"; ?>" data-multi-expand="<?php echo $multi_expand ? "true": "false"; ?>">
							<?php while( $q->have_posts() ) :  $q->the_post(); ++$fio_counter; ?>						
								<li class="accordion-item<?php echo $first_item_open && $fio_counter == 1 ? " is-active" : ""; ?>" data-accordion-item>
									<a href="#" class="accordion-title"><?php echo get_the_title(); ?></a>
									<div class="accordion-content" data-tab-content><?php echo wpautop( get_the_content() ); ?></div>
								</li>							
								<?php if($layout == "two-column-accordion" && $contents['faq_post_type']): 
									if($current_row < $col_max_length) {
										$current_row++;
										if($current_row == $col_max_length) break;
									}
								endif; ?>
							<?php endwhile; ?>   									
						</ul>
						<?php else : $allow_deep_link = isset($contents['allow_deep_link']) ? $contents['allow_deep_link'] : false?>	


							<?php if( $contents['accordions'] ): $fio_counter = 0; ?>

								<ul class="accordion" data-accordion data-allow-all-closed="<?php echo $all_closed ? "true": "false"; ?>" data-multi-expand="<?php echo $multi_expand ? "true": "false"; ?>"<?php echo $allow_deep_link ? ' data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge-delay="500" id="deeplinked-accordion"' : ''; ?>>

								<?php foreach($contents['accordions'] as $accordion) : ++$fio_counter;
									$accordion_pannel_id = $allow_deep_link && isset($accordion['accordion_pannel_id']) ? $accordion['accordion_pannel_id'] : "";
									?>

									<li class="accordion-item<?php echo $first_item_open && $fio_counter == 1 ? " is-active" : ""; ?>" data-accordion-item>
									<a href="#<?php echo $accordion_pannel_id; ?>" class="accordion-title"><?php echo $accordion['title']; ?></a>
										<div class="accordion-content" data-tab-content<?php echo $accordion_pannel_id ? ' id="'.$accordion_pannel_id.'"' : '';?>><?php echo $accordion['description']; ?></div>
									</li>	

								<?php endforeach; ?>

								</ul>

							<?php endif; ?>  									
						
						<?php endif; ?>
					</div>		
				<?php endif; ?>	
				<?php if( $layout == 'two-column-accordion' && ( ( $contents['faq_post_type'] && $q->have_posts() ) || $contents['accordions2'] ) ) : ?>
					<div class="cell accordion-container">	
						<?php if($contents['faq_post_type']) : $fio_counter = 0; ?>					
						<ul class="accordion" data-accordion data-allow-all-closed="<?php echo $all_closed ? "true": "false"; ?>" data-multi-expand="<?php echo $multi_expand ? "true": "false"; ?>">
							<?php while( $q->have_posts() ) :  $q->the_post(); ?>	
								<?php if($current_row >= $col_max_length) : ++$fio_counter;?>						
									<li class="accordion-item<?php echo $first_item_open && $fio_counter == 1 ? " is-active" : ""; ?>" data-accordion-item>
										<a href="#" class="accordion-title"><?php echo get_the_title(); ?></a>
										<div class="accordion-content" data-tab-content><?php echo wpautop( get_the_content() ); ?></div>
									</li>							
								<?php endif; $current_row++; ?>
							<?php endwhile; ?>   									
						</ul>
						<?php else : $allow_deep_link = isset($contents['allow_deep_link']) ? $contents['allow_deep_link'] : false; ?>	
							<?php if( $contents['accordions2'] ): $fio_counter = 0; ?>

								<ul class="accordion" data-accordion data-allow-all-closed="<?php echo $all_closed ? "true": "false"; ?>" data-multi-expand="<?php echo $multi_expand ? "true": "false"; ?>"<?php echo $allow_deep_link ? ' data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge-delay="500" id="deeplinked-accordion"' : ''; ?>>

								<?php foreach($contents['accordions2'] as $accordion) : ++$fio_counter;
									$accordion_pannel_id = $allow_deep_link && isset($accordion['accordion_pannel_id']) ? $accordion['accordion_pannel_id'] : "";
									?>

									<li class="accordion-item<?php echo $first_item_open && $fio_counter == 1 ? " is-active" : ""; ?>" data-accordion-item>
									<a href="#<?php echo $accordion_pannel_id; ?>" class="accordion-title"><?php echo $accordion['title']; ?></a>
										<div class="accordion-content" data-tab-content<?php echo $accordion_pannel_id ? ' id="'.$accordion_pannel_id.'"' : '';?>><?php echo $accordion['description']; ?></div>
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