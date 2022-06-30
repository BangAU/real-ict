<?php
    $hs = new hicaliber_theme_helpers; 
	$pcb = new hcContentBuilder();

	$layout = _get_sub_field_value('cpts_tabs_layout');
	$design = _get_sub_field_value('cpts_tabs_design');

	$header = _get_sub_field_value('cpts_tabs_header');
	
	$section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'project-element', 'project-tabbed-content', 'tabbed-content', 'bg-helper', $design['section_classes'], $design['theme'], $layout, $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );

    if(_have_rows('proj_tabbed_content') || $pcb->hasHeader($header)) :
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

	<?php echo $hs::design_background_image( $design['background_image'] ); ?>

	<div class="inner-section">
		<div class="grid-container">
			<?php $pcb->printHeader($header); ?>
			
			<div class="grid-x grid-padding-x">
				<div class="cell">
					<div class="main-button-container tab-group with-tab-slider text-center">
						
						<?php if( _have_rows('proj_tabbed_content') ): ?>
						
						<ul class="menu tab-slider">
							
						<?php   
								$is_there_an_active = false;
								$i = 0;
								
								while( _have_rows('proj_tabbed_content') ) : the_row();
						?>
							<li>
							<?php
								$title = _get_sub_field_value('title');
								if($title){
									
									$btn = [
									'url'          => '',
									'title'        => $title,
									'target'       => '#tab-content-'.$i
									];
			
									$button = new hcPCBButtonElement($btn);
									$button->setID('tabbtn-'.$i);
									$button->toggleClass('tab');
									if(!$is_there_an_active){
										$button->toggleClass('active'); 
										$is_there_an_active = true;
									}
									$button->displayButtonElement();

									$i++;
								}
							?> 
							</li>
						<?php   endwhile; ?>

						</ul>
						
						<?php endif; ?>

					</div>
				</div>
				
				<div class="cell small-12">
					<?php   
					$is_there_an_active = false;
					$i = 0;
					if( _have_rows('proj_tabbed_content') ): ?>
					<!--tab-content-slider-->
						<div class="tab-content-wrapper ">
						<?php while( _have_rows('proj_tabbed_content') ) : the_row(); ?>
							<div class="tab-content<?php 
								if(!$is_there_an_active){
									echo ' active'; 
									$is_there_an_active = true;
								}
							?>" id="<?php echo 'tab-content-'.$i; ?>">
								<?php 
									$content = _get_sub_field_value('content');
									if( $content )  :
										echo $content;
									else : 
								?>   
							
								<h5 class="text-center confirmation-message-container">Sorry, there are currently no content to display.</h5>
								
								<?php endif;  ?>
							</div>
						<?php
								$i++;
							endwhile;
						?>
						</div>
					<?php 
					endif;
					?>
				</div>

			</div>
		</div>
	</div>
</section>

<?php endif; ?>