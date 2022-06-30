<?php

    require_once 'team-post.php';

    // populating team name to Form with parameter name team_name 
    add_filter('gform_field_value_team_name', function( $value  ){
	    $string = '';
	    if(is_singular('team')) {	
		    $string = get_the_title();		    	    
	    }
	    return $string;
	});

	function hic_set_team_sc($atts) {

		ob_start(); 


		$a = shortcode_atts( array(
		 		'id' => '',
		 	), $atts ); 


	if(is_singular('team')) :


		$fb = _get_field_value('tp_facebook');
		$instra = _get_field_value('tp_linkedin');
		$in = _get_field_value('tp_instagram');
		$youtube = _get_field_value('tp_youtube');



		?>	



			<?php if($fb || $instra || $in || $youtube) : ?>
				<div class="social-media">
					 <?php if($fb) : ?>
	                    <li class="facebook">
	                    	<a href="<?php echo $fb; ?>" class="tp-social-link" target="_blank">
	                    		<i class="fab fa-facebook-f"></i>
	                    	</a>
	                    </li>
	                <?php endif; ?>
	                <?php if($instra) : ?>
	                	<li class="instagram">				                                        						                                        	
	                    	<a href="<?php echo $instra; ?>" class="tp-social-link" target="_blank">
	                    		<i class="fab fa-instagram"></i>
	                    	</a>
	                    </li>
	                <?php endif; ?>
	                 <?php if($in) : ?>
	                	<li class="linkedin">				                                        						                                        	
	                    	<a href="<?php echo $in; ?>" class="tp-social-link" target="_blank">
	                    		<i class="fab fa-linkedin-in"></i>
	                    	</a>
	                    </li>
	                <?php endif; ?>
	                 <?php if($youtube) : ?>
	                	<li class="youtube">				                                        						                                        	
	                    	<a href="<?php echo $youtube; ?>" class="tp-social-link" target="_blank">
	                    		<i class="fab fa-youtube"></i>
	                    	</a>
	                    </li>
	                <?php endif; ?>
				</div>
				<?php endif; ?>
		

		<?php endif; ?>


		<?php return ob_get_clean();
	}

	add_shortcode('team_social_media', 'hic_set_team_sc');

if( function_exists('acf_add_options_page') ) {
 
   	acf_add_options_page( array( 
		'page_title' 	=> 'Settings (Team)',
		'parent'     => 'edit.php?post_type=team',
		'capability'	=> 'edit_theme_options'
	));

}