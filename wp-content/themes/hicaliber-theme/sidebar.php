<div class="sidebar primary-sidebar">
	<div class="sidebar-element">


		<div class="grid-x grid-padding-x">
			<div class="cell">
				<div class="sidebar-content" role="complementary">
					<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar1' ); ?>

					<?php else : ?>

					<!-- This content shows up if there are no widgets defined in the backend. -->
										
					<div class="alert help">
						<p><?php _e( 'Please activate some Widgets.', 'jointswp' );  ?></p>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		
	</div>
</div>
<!-- end .sidebar -->	