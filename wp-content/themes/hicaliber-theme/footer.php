<?php
/**
 * The template for displaying the footer. 
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */			
 ?>
				<?php  
					get_template_part( 'page-content-builder/elements/content', 'modal' );
					
					$foooter_layout = get_field('site_footer_layout','options');

					$setting_url = admin_url("admin.php");

					if(current_user_can('administrator')) {
						$setting_url = admin_url("admin.php?page=acf-options-theme-general-settings");
					} elseif (current_user_can('editor')) {
						$setting_url = admin_url("admin.php?page=acf-options-theme-settings");
					}
				?>

				<?php
					// for fullscreen menu
					if( _get_field_value('enable_full_screen_menu','options') ) {
						hical_fsm_display_menu(); 
					}
				?>

				<footer class="footer <?php echo $foooter_layout; ?>" role="contentinfo">
					
					<?php //$site_footer_layout = _get_field_value('site_footer_layout', 'options'); ?>

					<?php //if($site_footer_layout == 'footer-layout-3') : ?>
						<?php 
							if( (is_singular('location') || is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options") ){
								$footer_link_field_name = 'ls_footer_columns';
								$title_field_name = 'ls_footer_col_title';
								$blurb_field_name = 'ls_footer_col_blurb';
								$select_element_field_name = 'ls_footer_col_element';
								$footer_col_editor_field_name = 'ls_footer_col_editor';
								$footer_back_to_top = 'ls_back_to_top_enable';
								$footer_back_to_top_options = 'ls_back_to_top_options';
							} else {
								$footer_link_field_name = 'g_site_footer_columns';
								$title_field_name = 'g_site_footer_col_title';
								$blurb_field_name = 'g_site_footer_col_blurb';
								$select_element_field_name = 'g_site_footer_col_element';
								$footer_col_editor_field_name = 'g_site_footer_col_editor';
								$footer_back_to_top = 'g_site_back_to_top_enable';
								$footer_back_to_top_options = 'g_site_back_to_top_options';
							}
						?>
						<div class="grid-container">
							<?php if(_get_field_value($footer_back_to_top, 'options')) : 
								$b2t_options = _get_field_value($footer_back_to_top_options, 'options');
							?>
							<div class="back-to-top-wrap">
								<div id="back-to-top" data-position="<?php echo $b2t_options['position']; ?>" data-icon-type="<?php echo $b2t_options['icon_type']; ?>">
									<?php if($b2t_options['tooltip']) : ?>
										<span class="b2t-tooltip"><?php echo $b2t_options['tooltip'] ?></span>
									<?php endif; ?>
									<?php if($b2t_options['icon_type'] == "icon") : ?>
										<span class="b2t-icon"><?php echo $b2t_options['icon'] ? $b2t_options['icon'] : '<i class="far fa-angle-up"></i>'; ?></span>
									<?php elseif($b2t_options['icon_type'] == "image") : ?>
										<span class="b2t-icon"><img src="<?php echo $b2t_options['image'] ? $b2t_options['image'] : get_template_directory_uri() . '/assets/images/arrow-top.png'; ?>" alt="Back to top"/></span>
									<?php endif; ?>
									<?php if($b2t_options['label']) : ?>
										<span class="b2t-label"><?php echo $b2t_options['label'] ?></span>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>
							<div class="inner-footer grid-x grid-padding-x">
								<?php if( _have_rows($footer_link_field_name,'options') ): 
									$col_counter = 0;
									while( _have_rows($footer_link_field_name,'options') ): the_row(); 
										// vars
										$title = _get_sub_field_value($title_field_name);
										$blurb = _get_sub_field_value($blurb_field_name);
										$select_element = _get_sub_field_value($select_element_field_name);
										$footer_col_editor = _get_sub_field_value($footer_col_editor_field_name);
										$col_counter++;
								?>
										<div class="cell large-auto footer-col footer-col-<?php echo $col_counter; ?>">
											<?php if( $title) : ?>
												<h4><?php echo $title ?></h4>
											<?php endif; ?>
											<?php if( $blurb) : ?>
											    <p class="subheading"><?php echo $blurb ?></p>
											<?php endif; ?>
											<?php 												
												 if( $select_element == 'logo' ) :
													get_template_part( 'parts/content', 'footer-logo' );
												endif;

												if( $select_element == 'contact-information' ) :
													get_template_part( 'parts/content', 'footer-ci' );
												endif;
												
												if( $select_element == 'primary-footer-menu' ) :
													joints_footer_links();
												endif;

												if( $select_element == 'secondary-footer-menu' ) :
													joints_footer_links_2();
												endif;

												if( $select_element == 'tertiary-footer-menu' ) :
													joints_footer_links_3();
												endif;

												if( $select_element == 'footer-4-menu' ) :
													joints_footer_links_4();
												endif;


												if( $select_element == 'text-editor' ) :
													echo '<div class="footer-blurb">';
													echo $footer_col_editor;
													echo '</div>';
												endif;

												if( $select_element == 'social-media' ) :
													set_social_media();
												endif;
											?>
										</div>
									<?php endwhile; ?>
								<?php endif; ?>
							</div>
						</div>

					
					



					<?php 

					/*

					 elseif($site_footer_layout == 'footer-layout-4') :  ?>

						<?php 
							$contact_details = _get_field_value('contact_details', 'options');
							$lat = $contact_details['location_latitude'];
							$long = $contact_details['location_longitude'];
						?>							 
						<div class="footer-map-container">
							<?php if($lat && $long) : ?>
								<div class="hical-map">
									<div id="marker" class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $long; ?>"></div>							
								</div>
							<?php endif; ?>
						</div>
							
						<div class="footer-info-box">		
							<?php if( _have_rows('g_site_footer_columns','options') ): 
								$col_counter = 0;
							?>
								<?php while( _have_rows('g_site_footer_columns','options') ): the_row(); 
									// vars
									$title = _get_sub_field_value('g_site_footer_col_title');
									$select_element = _get_sub_field_value('g_site_footer_col_element');
									$col_counter++;
								?>
									<h4><?php echo $title ?></h4>
									<?php 	
										if( $select_element == 'logo' ) :
											get_template_part( 'parts/content', 'footer-logo' );
										endif;
										if( $select_element == 'contact-information' ) :
											get_template_part( 'parts/content', 'footer-ci' );
										endif;
										if( $select_element == 'social-media' ) :
											set_social_media();
										endif;
										if( $select_element == 'text-editor' ) :
											echo '<div class="footer-blurb">';
											echo _get_sub_field_value('g_site_footer_col_editor');
											echo '</div>';
										endif;
										if( $select_element == 'primary-footer-menu' ) :
											joints_footer_links();
										endif;
									?>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>

					<?php else : ?>
						<div class="innter-footer">												
							<div class="grid-container">
								<div class="grid-x grid-padding-x">

										<div class="cell footer-head">
											<div class="footer-head-left">
												<?php get_template_part( 'parts/content', 'footer-logo' ); ?>
											</div>
											<div class="footer-head-right">
												<a class="button" href="#">News Letter Signup</a>
											</div>
										</div>

									<?php if( _have_rows('g_site_footer_columns','options') ): 
										$col_counter = 0;
									?>
										<?php while( _have_rows('g_site_footer_columns','options') ): the_row(); 
											// vars
											$title = _get_sub_field_value('g_site_footer_col_title');
											$select_element = _get_sub_field_value('g_site_footer_col_element');
											$col_counter++;
										?>
											<div class="cell medium-3 footer-col footer-col-<?php echo $col_counter; ?>">
												<?php if($title): ?>
											<h4><?php echo $title ?></h4>
											<?php endif; ?>
											<?php 
											
											    if( $select_element == 'logo' ) :
													get_template_part( 'parts/content', 'footer-logo' );
												endif;

												if( $select_element == 'contact-information' ) :
													get_template_part( 'parts/content', 'footer-ci' );
												endif;
												
												if( $select_element == 'primary-footer-menu' ) :
													joints_footer_links();
												endif;

												if( $select_element == 'secondary-footer-menu' ) :
													joints_footer_links_2();
												endif;

												if( $select_element == 'tertiary-footer-menu' ) :
													joints_footer_links_3();
												endif;

												if( $select_element == 'footer-4-menu' ) :
													joints_footer_links_4();
												endif;


												if( $select_element == 'text-editor' ) :
													echo '<div class="footer-blurb">';
													echo get_sub_field('g_site_footer_col_editor');
													echo '</div>';
												endif;

												if( $select_element == 'social-media' ) :
													set_social_media();
												endif;
											 ?>
											</div>
										<?php endwhile; ?>
									<?php endif; ?>
								</div> <!-- end #inner-footer -->
							</div>
						</div>
					<?php endif; ?>
					*/
					 ?>	

				</footer> <!-- end .footer -->
			
				<?php get_template_part( 'parts/content', 'bottom-footer' ); ?>
				
			</div>  <!-- end .off-canvas-content -->
					
		</div> <!-- end .off-canvas-wrapper -->
		
		<?php wp_footer(); ?>
		
	</body>
	
</html> <!-- end page -->