<!-- By default, this menu will use off-canvas for small
	 and a topbar for medium-up -->

<div class="top-bar" id="top-bar-menu">

	<div class="top-layer-bar clearfix">		
		<div class="phone">
			<?php set_primary_number(); ?>
		</div>
		<div class="social-phone">						
			<?php set_social_media(); ?>
		</div>		
	</div>

	<div class="bottom-layer-bar clearfix">
			<div class="logo-wrap">				
				<a href="<?php echo home_url(); ?>">
					<?php if( _get_field_value('g_site_logo', 'options') ) : ?>
						<img class="logo" src="<?php echo _get_field_value('g_site_logo', 'options'); ?>" alt="<?php echo get_bloginfo('title'); ?>">
					<?php else: ?>
						<?php echo get_bloginfo('title'); ?>
					<?php endif; ?>
				</a>				
			</div>

		<div class="menu-wrap">
			<?php  
				if( has_nav_menu('main-nav') ){
					echo joints_top_nav();
				} else {
					echo '<a href="'.admin_url('nav-menus.php').'"> Add Menu Here</a>';
				}				
			?>
		</div>
	</div>
	
</div>