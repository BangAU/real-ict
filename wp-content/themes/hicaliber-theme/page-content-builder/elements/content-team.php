<?php
	$hs = new hicaliber_theme_helpers;
	$pcb = new hcContentBuilder(); 
					
	$layout = $elements['team_section_layout'];
	$content = $elements['team_section_content'];
    $design = $elements['team_section_design'];
    $footer = $elements['team_section_footer'];

    $disabled_single_page = get_field('team_exclude_from_search','options');

	$categories = isset($content['categories']) ? $content['categories'] : "";
	$section_css = "";

	$orderby = isset($content['order_by']) ? $content['order_by'] : "date";
	$order = isset($content['order']) ? $content['order'] : "desc";

	$filter_type = isset( $content['search_filter_type'] ) ? $content['search_filter_type'] : "none";
	$display_filter = isset( $content['display_filter'] ) ? $content['display_filter'] : array();
	
	if($filter_type != "none"){
		$html_before_section = "";
		$filter = "";
		$group = count($display_filter) > 1;
		
		if($group){
			$filter .= "<div class='filter-group'>";
		}

		if( in_array("category", $display_filter ) ) {
			
			$terms = [];
			
			$cat_params = [
				'hide_empty' => true,
			];
			
			if( !empty( $categories )  ) {
				$cat_params['include'] = $categories;
			}
			
			$terms = get_terms( 'team_cat', $cat_params );
			
			if($filter_type == 'button'){
				$filter .= "<ul class='isotope-nav' data-filter-group='category'>";
				$filter .= "<li class='active' data-filter='*'>All</li>";
				foreach ( $terms as $term ) {
					$filter .= "<li data-filter='.{$term->slug}'>{$term->name}</li>";
				}
				$filter .= "</ul>";
			} elseif($filter_type == 'dropdown') {
				$filter .= "<select class='nice-select isotope-select' data-filter='category'>";
				$filter .= "<option value='*'>Select Category</option>";
				foreach ( $terms as $term ) {
					$filter .= "<option value='.{$term->slug}'>{$term->name}</option>";
				}
				$filter .= "</select>";
			}
		} 
		
		if( in_array("location", $display_filter) ){
			
			$loc_args = array(
				'post_type'         => 'location',
				'post_status'       => 'publish',
				'posts_per_page'	=> -1,
				'orderby'			=> 'title',
				'order'				=> 'ASC',
			);
			
			$loc = new WP_Query( $loc_args );
	
			if(  $loc->have_posts() ) :
	
				if($filter_type == 'button'){
					$filter .= "<ul class='isotope-nav' data-filter-group='location'>";
					$filter .= "<li class='active' data-filter='*'>All</li>"; 
					
					while( $loc->have_posts() ) : $loc->the_post();
						$slug = basename(get_permalink(get_the_ID()));
						$title = get_the_title();
						$filter .= "<li data-filter='.{$slug}'>{$title}</li>";
					endwhile; 
		
					$filter .= "</ul>";
				} elseif($filter_type == 'dropdown') {
					$filter .= "<select class='nice-select isotope-select' data-filter='location'>";
					$filter .= "<option value='*'>Select Location</option>"; 
					
					while( $loc->have_posts() ) : $loc->the_post();
						$slug = basename(get_permalink(get_the_ID()));
						$title = get_the_title();
						$filter .= "<option value='.{$slug}'>{$title}</option>";
					endwhile; 
		
					$filter .= "</select>";
				}
				
			endif; wp_reset_postdata(); 
		}

		if($group){
			$filter .= "</div>";
		}

		$html_before_section .= "<div class='grid-x grid-padding-x section-filter  " . $filter_type . "-filter'><div class='cell'>{$filter}</div></div>";

		$pcb->setExtraHTML($html_before_section, 1); 
	}
	
    $section_css = $hs::css_class_helper(
       [ 'page-element', 'team-element', $design['section_classes'], $layout['layout_type'], $layout['content_boxes_display'],($layout['layout_type'] == 'grid') ? $layout['grid_layout'] : '', $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

     if($layout['slider_autoplay']) {        
        $set_data_autoplay = 'data-autoplay=1 data-autoplay-speed='.$layout['slider_speed'];    
    } else {
    	$set_data_autoplay = '';
    }
?>

	<?php 
		$args = array(
			'posts_per_page' => -1,
			'post_type' =>	'team',
			'status'	=>	'publish',
			'orderby' 	=> 	$orderby,
			'order'		=>	$order,

		);

		if($categories) 
			$args['tax_query'] = array(
			array(
				'taxonomy'  => 'team_cat',
				'field'     => 'id', 
				'terms'     => $categories,
				'operator' => 'IN'
			)
		); 

		$agents = New WP_Query( $args );

	?>
					<?php  if( $agents->have_posts() ) : ?>	
<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

	<?php echo $hs::design_background_image( $design['background_image'] ); ?>
	
	<div class="inner-section">
		<div class="grid-container">
			<?php $pcb->printHeader($elements['team_section_header']); ?>
			<?php echo $pcb->getExtraHTML(1); ?>
			<div class="grid-x grid-padding-x section-body" data-item-col="<?php echo $layout['per_row']; ?>" <?php echo $set_data_autoplay; ?>>
								

					<?php while ( $agents->have_posts() ) : $agents->the_post();

							$custom_url = FALSE;

							$iso_class = [];

							if($filter_type != "none"){
								if( in_array("category", $display_filter ) ){
									$team_terms = get_the_terms(get_the_ID(), 'team_cat');
	
									if( $team_terms ) {
										foreach( $team_terms as $term ) {
											$iso_class[] = $term->slug;
										}
									}
								} 
								
								if( in_array("location", $display_filter ) ){
									$locations = _get_field_value('link_to_location');
									if( is_array( $locations ) ){
										foreach( $locations as $location ){
											$iso_class[] = basename(get_permalink($location)); 
										}
									}
								}
							}

							$iso_class = implode(" ", $iso_class );

							$agent_page = get_permalink();

							$agent_full_name = get_the_title();

							$the_id = get_the_ID();
							$user_id = get_post_meta( $the_id, 'manager_user_id', true );

							$user_data = get_userdata( $user_id );

							$agent_position = _get_field_value('tp_job_title');
							$agent_photo = _get_field_value('tp_profile_image');

							if($agent_photo == null) {
								$agent_photo =get_template_directory_uri() . "/assets/images/avatar_placeholder.jpeg";
							}
							$image_class = '';
							
							$agent_phone = _get_field_value('tp_phone_number');
							$agent_email = _get_field_value('tp_email_address');
							$fb = _get_field_value('tp_facebook');
							$instra = _get_field_value('tp_linkedin');
							$in = _get_field_value('tp_instagram');
							$youtube = _get_field_value('tp_youtube');
							$custom_link = _get_field_value('tp_custom_link');						

							$blurb = wp_trim_words(get_the_content(), $content['max_number_of_words']);
							
							if(has_excerpt() && $content['text_to_display'] == 'excerpt') {
								$blurb = get_the_excerpt();
							}
							if($content['text_to_display'] == 'full') {
								$blurb = wpautop(get_the_content());
							}
							

							if($agent_photo) {
								$image_class = 'has-media has-image';
							}

							$slug = get_post_field( 'post_name', get_the_ID() );
								
						?>

							<div id="<?php echo $slug; ?>" class="cell team-list team-item <?php echo $layout['per_row']; ?><?php echo " " . $iso_class; ?><?php echo $image_class;?>">
								<div class="hic-box">
									<div class="hic-image-container">
										<div class="hic-image team-member-avatar bg-helper" style="background-image: url(<?php echo $agent_photo; ?>)"></div>
									</div>								
										
										<div class="hic-content">
											<div class="member-details">
												<div class="member-name"><?php _e($agent_full_name); ?></div>
												<div class="member-position"><?php _e($agent_position); ?></div>

												<?php if($content['content_to_display'] && in_array('contact', $content['content_to_display'])) : ?>

												<div class="contact-details">
													<div class="member-phone">
														<a href="tel:<?php _e(str_replace(" " , "", $agent_phone)); ?>"><?php _e($agent_phone); ?></a>
													</div>
													<div class="member-email">
														<a href="mailto:<?php _e($agent_email); ?>">
															<?php _e($agent_email); ?>
														</a>
													</div>
													<?php if($fb || $instra || $in || $youtube) : ?>
													<div class="social-media">
														 <?php if($fb) : ?>
				                                            <li class="facebook">
				                                            	<a href="<?php echo $fb; ?>" class="tp-social-link" target="_blank">
				                                            		<i class="fab fa-facebook-f"></i>
				                                            	</a>
				                                            </li>
				                                        <?php endif; ?>
				                                        <?php if($instra) : ?>
				                                        	<li class="instagram">				                                        						                                        	
				                                            	<a href="<?php echo $instra; ?>" class="tp-social-link" target="_blank">
				                                            		<i class="fab fa-instagram"></i>
				                                            	</a>
				                                            </li>
				                                        <?php endif; ?>
				                                         <?php if($in) : ?>
				                                        	<li class="linkedin">				                                        						                                        	
				                                            	<a href="<?php echo $in; ?>" class="tp-social-link" target="_blank">
				                                            		<i class="fab fa-linkedin-in"></i>
				                                            	</a>
				                                            </li>
				                                        <?php endif; ?>
				                                         <?php if($youtube) : ?>
				                                        	<li class="youtube">				                                        						                                        	
				                                            	<a href="<?php echo $youtube; ?>" class="tp-social-link" target="_blank">
				                                            		<i class="fab fa-youtube"></i>
				                                            	</a>
				                                            </li>
				                                        <?php endif; ?>
													</div>
													<?php endif; ?>
												</div>

											<?php endif; ?>

											<?php if($content['content_to_display'] && in_array('description', $content['content_to_display'])) : ?>
											<div class="hic-blurb">
												<?php echo $blurb; ?>
											</div>
											<?php endif; ?>

											<?php if($content['content_to_display'] && in_array('button', $content['content_to_display'])) : ?>

												<?php if(!$disabled_single_page || (!empty($custom_link) && $custom_link['url']) ) : ?>
																								
													<div class="hic-button-wrap">
														<?php															
															$button = new hcPCBButtonElement();
															$button_label = get_field("team_listing_button_label", "option");
															$button_label = !empty($button_label) ? $button_label : "View Profile";
															$button_target = "";

															if(!empty($custom_link) && $custom_link['title']) {
																$button_label = $custom_link['title'];
															}

															if(!empty($custom_link) && $custom_link['target']) {
																$button_target = $custom_link['target'];
															}

															if(!empty($custom_link) && $custom_link['url']) {
																$agent_page = $custom_link['url'];
															}
															$button->constructButton($agent_page, $button_label, $button_target);
															$button->toggleClass('primary-white-button');
															//$button->toggleClass('uppercase');
															$button->displayButtonElement();															
														?>
													</div>

												<?php endif; ?>

											<?php endif; ?>

											</div>
											
										</div>
									
								</div>
								
							</div>

					<?php endwhile; ?>
			
			</div>

			<?php $pcb->printFooter($elements['team_section_footer']); ?>
		</div>
	</div>
</section>
					<?php endif; wp_reset_postdata(); ?>