<?php 
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();
							
    $section_content = $elements['main_cta_content']; 
    $design = $elements['main_cta_design']; 
	$section_main_layout = $elements['main_cta_layout']; 
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'cta-element', $section_main_layout['display'], $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">
											
    
    <?php echo $hs::design_background_image( $design['background_image'] ); ?> 

    <div class="inner-section">
		<div class="grid-container">
			<?php 
				if($section_content['featured_video']) : 
			?>
			<div class="grid-x grid-padding-x section-top">
				<div class="cell medium-12 cta-feature-video">
					<?php if($section_content['video_url']) : ?>
		
					<a href="<?php echo $section_content['video_url']; ?>" data-fancybox><img class="icon" src="<?php echo ASSETS_IMG; ?>element-images/play-Icon.png"></a>
					
					<?php endif; ?>
				</div>
			</div>
			<?php 
				endif; 
					
			$pcb->printHeader($elements['main_cta_header']);

			?>
			<div class="grid-x grid-padding-x section-body">
				<div class="cell">
					<?php if($section_content['content']) : ?>
					<div class="cta-blurb">
						<?php _e($section_content['content']); ?> 
					</div>
					<?php endif; ?>
					
					<?php if($section_content['group_button'] && is_array($section_content['group_button'])) : ?>
					<div class="hic-button-wrap">
					<?php
						foreach($section_content['group_button'] as $btn) :
							if($btn['button_target'] == 'modal'){
								$button = new hcPCBButtonElement($btn['modal']);
								$button->toggleClass('footer-button');
								$button->displayButtonElement();
							} else 
								if($btn['link']){
									$button = new hcPCBButtonElement($btn['link']);
									$button->displayButtonElement();
								}
								
						endforeach; 
					?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
    </div>
   
</section>