<?php 
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();
    
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'event-description', 'default-theme', 'default-width', 'default-alignment']
    );
    
?>

<section class="<?php echo $section_css; ?>">
    <div class="inner-section">
		<div class="grid-container">
            <div class="grid-x grid-padding-x section-body">
                <div class="cell">
                    <?php tribe_events_before_html(); ?>
                    <?php tribe_get_view(); ?>
                    <?php tribe_events_after_html(); ?>
                </div>		
            </div>	
		</div>
	</div>
</section>