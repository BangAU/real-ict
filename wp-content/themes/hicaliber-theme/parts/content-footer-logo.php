<?php 
										$custom_footer_logo = _get_field_value('site_footer_custom_logo', 'options');
										$logo_link = home_url();

										if( is_singular('location') && _get_field_value("ls_location_custom_design", "options")){
											$loc_logo = _get_field_value('footer_logo');
											$custom_footer_logo = $loc_logo ? $loc_logo : $custom_footer_logo;
											$logo_link = get_location_base_url();
										} elseif( (is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")) {
											$parent_id = _get_field_value('link_to_location');
											$loc_logo = _get_field_value('footer_logo', $parent_id);
											$custom_footer_logo = $loc_logo ? $loc_logo : $custom_footer_logo;
											$logo_link = get_location_base_url();
										} 

										$site_logo = ($custom_footer_logo) ? $custom_footer_logo : _get_field_value('g_site_logo', 'options'); 
									?>
									<div class="logo-wrap">
										<?php if(!$site_logo) : ?>
												<a href="<?php echo $logo_link; ?>">
<img class="logo show-for-large" src="<?php echo get_template_directory_uri() . '/assets/images/logo-default.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>"<?php if( _get_field_value('g_site_logo_width', 'options') || _get_field_value('g_site_logo_height', 'options') ) : ?> style="width: <?php echo _get_field_value('g_site_logo_width', 'options'); ?>px; height: <?php echo _get_field_value('g_site_logo_height', 'options') ?>px"<?php endif; ?> >
											<img class="logo hide-for-large" src="<?php echo get_template_directory_uri() . '/assets/images/logo-default.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>" >
										<?php endif; ?>
										<a href="<?php echo ($site_logo) ? $logo_link : $setting_url; ?>" <?php echo (!$site_logo) ? 'class="no-logo"' : ''; ?>>
											<?php if( $site_logo ) : ?>

													<img class="logo show-for-large" src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo('title'); ?>"<?php if( _get_field_value('site_footer_custom_logo_width', 'options') || _get_field_value('site_footer_custom_logo_height', 'options') ) : ?> style="width: <?php echo _get_field_value('site_footer_custom_logo_width', 'options'); ?>px; height: <?php echo _get_field_value('site_footer_custom_logo_height', 'options') ?>px"<?php endif; ?> >
													<img class="logo hide-for-large" src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" >

											<?php else: ?>
											
											<?php endif; ?>
										</a>
									</div>