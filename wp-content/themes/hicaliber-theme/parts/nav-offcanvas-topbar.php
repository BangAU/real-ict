<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
?>

<?php 
	//variables
	$site_logo = _get_field_value('g_site_logo', 'options');
	$logo_link = home_url();

	if( is_singular('location') && _get_field_value("ls_location_custom_design", "options") ){
		$loc_logo = _get_field_value('header_logo');
		$site_logo = $loc_logo ? $loc_logo : $site_logo;
		$logo_link = get_location_base_url();
	} elseif( ( is_singular('location_post') || is_singular('location_page') ) && _get_field_value("ls_location_custom_design", "options") ) {
		$parent_id = _get_field_value('link_to_location');
		$loc_logo = _get_field_value('header_logo', $parent_id);
		$site_logo = $loc_logo ? $loc_logo : $site_logo;
		$logo_link = get_location_base_url();
	} 

	$setting_url = admin_url("admin.php");
	if(current_user_can('administrator')) {
		$setting_url = admin_url("admin.php?page=acf-options-theme-general-settings");
	} elseif (current_user_can('editor')) {
		$setting_url = admin_url("admin.php?page=acf-options-theme-settings");
	}
				
?>

<div class="top-bar" id="top-bar-menu">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="cell topbar-inner">
				<div class="top-bar-left float-left">
					<div class="logo-wrap">	
						<?php if(!$site_logo) : ?>
							<a href="<?php echo $logo_link; ?>">
								<img class="logo show-for-large" src="<?php echo get_template_directory_uri() . '/assets/images/logo-default.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>"<?php if( _get_field_value('g_site_logo_width', 'options') || _get_field_value('g_site_logo_height', 'options') ) : ?> style="width: <?php echo _get_field_value('g_site_logo_width', 'options'); ?>px; height: <?php echo _get_field_value('g_site_logo_height', 'options') ?>px"<?php endif; ?> >
								<img class="logo hide-for-large" src="<?php echo get_template_directory_uri() . '/assets/images/logo-default.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>" >
							</a>
						<?php endif; ?>

						<a href="<?php echo ($site_logo) ? $logo_link : $setting_url; ?>" <?php echo (!$site_logo) ? 'class="no-logo"' : ''; ?>>
							<?php if( $site_logo ) : ?>

								<?php $custom_logo_size = _get_field_value('logo_custom_size','options'); ?>
								<?php if($custom_logo_size) : ?>
								<img class="logo show-for-large" src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo('title'); ?>"<?php if ( _get_field_value('g_site_logo_width', 'options') || _get_field_value('g_site_logo_height', 'options') ) : ?> style="width: <?php echo _get_field_value('g_site_logo_width', 'options'); ?>px; height: <?php echo _get_field_value('g_site_logo_height', 'options') ?>px"<?php endif; ?> >
								<?php endif; ?>

								<img class="logo <?php echo ($custom_logo_size) ? 'hide-for-large' : ''; ?>" src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo('title'); ?>" >
							<?php else: ?>
							
							<?php endif; ?>
						</a>
					</div>
				</div>
				<div class="top-bar-right float-right show-for-large">
					<div class="top">
						<?php if(_get_field_value('opt_cusom_menu_area', 'options')) : 
							$custom_menu_content = _get_field_value('opt_custom_menu_area_content', 'options'); ?>
							<?php if($custom_menu_content) : ?>
								<div class="menu-container show-for-large">
									<?php echo $custom_menu_content; ?>
								</div>
							<?php endif; ?>
						<?php else : ?>		
							<div class="menu-container show-for-large">
								<?php 
									$custom_top_menu =  _get_field_value( 'page_menu_item' );  

									if( is_singular('location') && _get_field_value("ls_location_custom_design", "options")){
										if(_get_field_value('location_custom_menu')){
											$custom_top_menu = _get_field_value('location_menu_item');
										}
									} elseif( (is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")) {
										$parent_id = _get_field_value('link_to_location');
										if(_get_field_value('location_custom_menu', $parent_id)){
											$custom_top_menu = _get_field_value('location_menu_item', $parent_id);
										}
									} 
									
									if( $custom_top_menu ) {
										wp_nav_menu(array(
											'container' => false,                                               
											'menu_class' => 'vertical medium-horizontal menu',                  
											'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
											'theme_location' => $custom_top_menu,        		                    
											'depth' => 5,                                               
											'fallback_cb' => false, 
											'walker' => new Topbar_Menu_Walker()
										));    
									} else {
										set_main_nav();  
									}
								?>
							</div>

							<?php
							if( is_element_exists('products') ) {
								
								$hicaliber_product = new PRODUCT_HELPER();

								if($hicaliber_product->hi_set_cart_icon()) {
									$hicaliber_product->hi_set_cart_icon(true);
								}

								if($hicaliber_product->is_fav_icon_visible()) {
									$hicaliber_product->hi_set_fav_icon();
								}

							} ?>
						<?php endif; ?>
					</div>
					
				</div>
				<div class="top-bar-right float-right hide-for-large">
					<ul class="menu top">
						<li class="elem"><?php set_primary_number(); ?></li>
						<?php
							if( is_element_exists('products') ) : ?>
								<li class="elem"><?php 
								$hicaliber_product = new PRODUCT_HELPER();

								if($hicaliber_product->hi_set_cart_icon()) {
									$hicaliber_product->hi_set_cart_icon(true);
								}

								if($hicaliber_product->is_fav_icon_visible()) {
									$hicaliber_product->hi_set_fav_icon();
								}
								?></li><?php
							endif;
						?>
						<?php if( _get_field_value('enable_full_screen_menu','options') ) : ?>
							<li class="elem"><button class="menu-icon burger-menu" type="button" id="fullscreenMenu"></button></li>
						<?php else : ?>
							<li class="elem"><button class="menu-icon burger-menu" type="button" data-toggle="off-canvas"></button></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	function set_main_nav() { ?>
		<?php if( (is_singular('location') || is_singular('location_post') || is_singular('location_page') ) && has_nav_menu('location-menu') && _get_field_value("ls_location_custom_design", "options")) : ?>
			<?php 
			    joints_location_menu(); 
			?>
		<?php else : 
				if(has_nav_menu('main-nav')):  
					joints_top_nav();
				else: ?>
				<div class="no-menu-message">
					Click <a href="<?php echo admin_url('nav-menus.php'); ?>">here</a> to add menu, set theme locations as The Main Menu.
				</div>
				<?php endif; ?>
		<?php endif; ?>
	<?php }
 ?>