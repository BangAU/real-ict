<div class="sidebar event_sidebar">
	<div class="sidebar-element">
		<div class="grid-x grid-padding-x">
			<div class="cell">
				<div class="sidebar-content" role="complementary">
					<?php if ( is_active_sidebar( 'event_sidebar' ) ) : ?>

						<?php dynamic_sidebar( 'event_sidebar' ); ?>

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