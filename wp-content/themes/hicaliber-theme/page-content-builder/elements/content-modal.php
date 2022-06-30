<?php
	if(_have_rows('ge_modal', 'options')) :
		$hs = new hicaliber_theme_helpers;
		while(_have_rows('ge_modal', 'options')) : the_row();
			$layout = _get_sub_field_value('ge_modal_layout');
			$design = _get_sub_field_value('ge_modal_design');
    	    $header = _get_sub_field_value('ge_modal_heading');
			$contents = _get_sub_field_value('ge_modal_content');
			$contents2 = _get_sub_field_value('ge_modal_content_2');
			$hasContent2 = ( isset($contents2['blurb']) ? $contents2['blurb'] : false ) || ( isset($contents2['gform']['id']) ? $contents2['gform']['id'] : false );
    	    $id = 'modal-elem-' . (get_row_index() - 1);
			$title = $header['peh_section_title'] ? $header['peh_section_title'] : _get_sub_field_value('g_modal_label');
			$field_values = "";
			
			if( is_singular("property_type") ){
				$field_values=' field_values="property_id='.get_the_ID().'&property_name='.get_the_title().'&property_url='.get_the_permalink().'"';
			} elseif( is_singular("design" ) ){
				$field_values=' field_values="design_id='.get_the_ID().'&design_name='.get_the_title().'&design_url='.get_the_permalink().'"';
			}

			$modal_classes = "";

			$modal_classes = $hs::css_class_helper(
			[ 'reveal', 'modal-element', $layout['layout_type'], $design['modal_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
			);
?>
<div class="<?php echo $modal_classes; ?>" id="<?php echo $id; ?>" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
	<?php echo $hs::design_background_image( $design['background_image'] ); ?>
	<div class="inner-modal">
		<div class="grid-container">
			<div class="grid-x grid-padding-x modal-header">
				<div class="cell medium-12">
					<h2 class="modal-title"><?php echo $title; ?></h2>
				</div>
			</div>
			<div class="grid-x grid-padding-x modal-content">
				<div class="cell <?php echo $hasContent2 && $layout['layout_type'] == 'two-column-layout' ? "medium-6" : "medium-12"; ?>">
					<?php if(isset($contents['blurb']) ? $contents['blurb'] : false ) : ?>
					<div class="modal-blurb"><?php echo $contents['blurb']; ?></div>
					<?php endif; ?>
					<?php if(isset($contents['gform']['id']) ? $contents['gform']['id'] : false ) : ?>
					<div class="modal-form"><?php
						echo do_shortcode('[gravityform id=' . $contents['gform']['id'] . ' title=false description=false ajax=true' . $field_values . ']'); 
					?></div>
					<?php endif; ?>
				</div>

				<?php if($hasContent2 && $layout['layout_type'] == 'two-column-layout') : ?>
					<div class="cell medium-6">
						<?php if(isset($contents2['blurb']) ? $contents2['blurb'] : false ) : ?>
						<div class="modal-blurb"><?php echo $contents2['blurb']; ?></div>
						<?php endif; ?>
						<?php if(isset($contents2['gform']['id']) ? $contents2['gform']['id'] : false ) : ?>
						<div class="modal-form"><?php
							echo do_shortcode('[gravityform id=' . $contents2['gform']['id'] . ' title=false description=false ajax=true' . $field_values . ']'); 
						?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<button class="close-button" data-close aria-label="Close modal" type="button">
		<span>×</span>
	</button>
</div>
<?php 
        endwhile; 
    endif; 
?>