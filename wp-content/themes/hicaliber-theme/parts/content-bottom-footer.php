<?php 

if( (is_singular('location') || is_singular('location_post') || is_singular('location_page')) && _get_field_value("ls_location_custom_design", "options")){
	$footer_link_field_name = 'ls_after_footer_link';
	$cr_msg = _get_field_value('ls_copyright_message','options');
} else {
	$footer_link_field_name = 'after_footer_link';
	$cr_msg = _get_field_value('opt_copyright_message','options');
}


?>
	<div class="bottom-footer<?php echo (_get_field_value($footer_link_field_name, 'options')) ? ' with-colophon-link' : ''; ?>">
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell">
					<?php if($cr_msg) : ?>
					    <div class="copyright">
					        <?php echo $cr_msg; ?>
					    </div>
						
					<?php else: ?>
					<div class="copyright">Hicaliber &copy; <?php echo date('Y'); ?>. All rights reserved.</div>
						<?php endif; ?>

					<?php if( _have_rows($footer_link_field_name, 'options') ): ?>

						<div class="colophon-link"><ul class="menu">

						<?php while( _have_rows($footer_link_field_name, 'options') ): the_row(); 

							// vars
							$link = _get_sub_field_value('after_footer_url');
							if( isset( $link['url'] ) ) {
							?>

							<li><a href="<?php echo $link['url']; ?>" <?php echo $link['target'] ? 'target="_blank"' : ''; ?>class="colophon-text"><?php echo $link['title']; ?></a></li>

						<?php } endwhile; ?>

						</ul></div>

					<?php endif; ?>
					
					<!-- <p class="privacy"> | </p> -->
				</div>
			
			
			</div>
		</div>
	</div>