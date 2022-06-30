<?php 


	class HI_TESTI_FUNCTIONS {
		
		function __construct(){
			add_action("load-edit.php", array( $this, 'edit_load') );
		}
		
		function edit_load(){
			$screen = get_current_screen();
			if (!isset($screen->post_type) || 'testimonials_type' != $screen->post_type) {
				return;
			}
			
			add_filter( "manage_{$screen->id}_columns", function($cols){
				unset($cols["date"]);
				unset($cols["author"]);
				unset($cols["taxonomy-testimonials_cat"]);
				$cols['name'] 		= __('Name');
				$cols['featured'] 	= __('Featured');
				$cols['taxonomy-testimonials_cat'] = __("Categories");
				$cols['author']	 	= __("Author");
				$cols['date']	 	= __("Date");
				return $cols;
			} );
			
			
			add_filter( "manage_{$screen->id}_sortable_columns", function($cols){
				$cols['name'] 		= "name";
				$cols['featured'] 	= "featured";
				return $cols;
			});
			
			add_action( "manage_{$screen->post_type}_posts_custom_column", function( $col, $post_id ){
				switch($col){
					case "name":
						echo get_field("t_name", $post_id);
					break;
					case "featured":
						echo  get_field("post_featured", $post_id) ? "<i class='dashicons dashicons-star-filled'></i>" : "<i class='dashicons dashicons-star-empty'></i>";
					break;
				}
			}, 10, 2 );
			
			add_action("admin_head", function(){
				?>
				<style>
					th.column-featured span:after { display: none !important; }
				</style>
				<?php
			});
		}

		

		public static function hi_testi_details() {

            $hs = new hicaliber_theme_helpers;
            
            $design = get_sub_field('cpts_desc_testi_design'); 

            $rating_val = get_field('t_rating');

            $ratings = ["none-selected","one","two","three","four","five"];
	        $html = "";
	        $rated = "<i class='fas fa-star'></i>";

	        foreach( $ratings as $i => $rating ) {
	            
	            if( $rating == $rating_val ) {
	                $rated = "<i class='far fa-star'></i>";        
	            }
	            
	            if( $i < (count($ratings) -1) ) {
	                $html .= $rated;    
	            }
	        }        


                  
            // Events Data from Post
              $featured_image = get_field('t_image');
			    $testi_video = get_field('t_video');
			    $testi_location = get_field('t_location');

            $section_css = $hs::css_class_helper(
                [ 'page-element', 'testimonial-element', $design['section_classes'] , $design['theme'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '', ]
             );            
        ?>



        <section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

            <?php echo $hs::design_background_image( $design['background_image'] ); ?>
            <div class="inner-section">
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell testimonial<?php echo ($testi_video) ? ' has-video' : ''; ?>">
				    <div class="hic-box">
				        <div class="hic-content testimonial-inner-wrap">
				            <div class="testimonial-main-content">
				               
				               <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    				            <div class="hic-blurb"><?php the_content(); ?></div>
                                <?php endwhile; endif; ?>
                                
                                
    				            <?php if($testi_video) : ?>
						        	<a href="<?php echo $testi_video; ?>" data-fancybox>  
						        <?php endif; ?>

    				             <?php if($featured_image) : ?>
    				             	<div class="hic-image-container">    				             		    				             
					                    <div class="hic-image primary-photo" style="background-image: url(<?php echo $featured_image; ?>)">
					                    	<?php if($testi_video) : ?>
					                    		<img class="video-play-button" src="<?php echo ASSETS_IMG . '/play-button.png'; ?>">
					                    	<?php endif; ?>
					                    </div>
				                    </div>
				                <?php endif; ?>

				                <?php if($testi_video) : ?>
						        	</a>
						        <?php endif; ?>

						       <?php if( $rating_val != 'none-selected' && $rating_val ) : ?>
			                        <div class="rating">
			                            <?php echo "<div class='testimonial-rating'>".$html."</div>"; ?>
			                        </div>
		                    	<?php endif; ?> 

						        <div class="client-details">
						        	<div class="hic-title"><h4><?php echo get_the_title(); ?></h4></div>
	    				            <div class="client-position">
	    				            	<?php echo $testi_location; ?>
	    				            </div>
						        </div>

    				           
				            </div>
				        </div>
					</div>
				</div>                      
                </div>                                     
            </div>
            </div>
        </section> 

        <?php
    }

    public static function hi_single_other_testi() {

        $pcb = new hcContentBuilder(); 

        $query_helper = new QUERY_HELPER();

        $layout = get_sub_field('cpts_related_layout');
    
        $PCBPrj = new hcPCBEvents();
        $PCBPrj->addDefaultSectionClasses($layout['display']);
        $pcb->setContentType($PCBPrj);
    
        $pcb->addClassesTo('section', [$layout['layout_type']]);
        if($layout['layout_type'] == 'grid') { 
            $pcb->addClassesTo('section', [$layout['grid_layout']]);
        }
        
        $id = get_the_ID();
        $include_based_on_location = [];
    
        $pcb->setSettings(get_sub_field('related_design'));
            
        $pcb->setClassesOf('section-body', ['section-body', $layout['layout_type']]);
        $pcb->setData('item-col', $layout['per_row']);
         if($layout['slider_autoplay']) {
             $pcb->setData('autoplay', 1);
        }
        if($layout['slider_autoplay']) {
             $pcb->setData('autoplay-speed', $layout['slider_speed']);
        }
    
        $pcb->setHeader(get_sub_field('cpts_related_header'));
     
        $content_options = get_sub_field('testi_content'); 
    
        $categories = array(); 
    
        $terms = get_the_terms($id, 'course_cat');
    
        if(is_array($terms)){
            foreach($terms as $term){
                array_push($categories, $term->term_id);
            }
        }
            
       // // $text_to_display = $content_options['text_to_display'];
       //  $content_to_display = $content_options['events_content_to_display'];    
       //  $max_word = $content_options['max_number_of_words'];
        
        $content_options['featured'] = FALSE;
    
    
        // if( is_array($content_to_display) ? !in_array('button', $content_to_display) : false || !$content_to_display ) $pcb->addClassesTo('section', ['button-hidden']);
    
        $listing_button_settings = _get_field_value('pjgs_action_btn_main', 'options');
    
        $button_label = (isset($listing_button_settings['label']) ? $listing_button_settings['label'] : false) ? $listing_button_settings['label'] : 'View event';
        
        $post_per_page = $content_options['testimonials_qty'] ? $content_options['testimonials_qty'] : -1;
    
        // if( $text_to_display == 'description') {
        //     $pcb->addClassesTo('section', 'has-description');
        // }
    
        // if( $text_to_display == 'excerpt') {
        //     $pcb->addClassesTo('section', 'has-excerpt');
        // }
    
        
            
            $param = [                
				'post_type' => 'testimonials_type',
		        'post_status' => 'publish',
		        'per_page'  => $post_per_page           
         
            ];
            
            // if( !empty( $categories ) ) {
            //    $categories =  implode( "','",  $categories );
            //    $categories = "('{$categories}')";   
            //    $param['cpt_category'] = "course_cat";
            //    $param['term_search'] = "term_id";
            //    $param['scl'] =  $categories;
            // }
            
            $results = $query_helper->qry( $param );
        
    
        $result_count = sizeof( $results );

        
        
        if(  $result_count ) :
            
            foreach( $results['data'] as  $result  ): 
            
            $id = $result;                          
            
            $content = "";
            // if( $text_to_display == 'excerpt' && has_excerpt( $id ) ){
            //     $content = wpautop( get_the_excerpt( $id ) );
            // } else {
            //     $max_word = $text_to_display == 'description' && $max_word ? $max_word : 35;
            //     $content = wp_trim_words( get_the_content( $id ) , $max_word ) ;
            // }
    
            $hicTesti = new hcPCBTestimonial();
            $hicTesti->setTitle( get_the_title( $id ) );
            // if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
            //     $terms = get_the_terms( $id , 'course_cat');
            //     if($terms && is_array($terms)) $hicTesti->setTerms($terms);
            // }
            // if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicTesti->setContent(  $content );
            //$hicTesti->setImage(new hcPCBLink( get_field('t_image', $id ) ));


            $hicTesti->setImage(new hcPCBLink( _get_field_value('t_image', $id) ));


            if($content_options['full_content']) {
                $hicTesti->setContent( get_the_content() );
            } else {
                $hicTesti->setContent( wp_trim_words( get_the_content(), 25, '...' ) );
            }
            
                        
            $button = new hcPCBButtonElement();
            $button->constructButton(get_the_permalink( $id ), $button_label );
            $hicTesti->setButton($button);
            
            $hicTesti->setClassesOf('hic-box-container', [ $layout['per_row'] ]);
             if(_get_field_value('post_featured')) {
                $hicTesti->setClassesOf('hic-box', [ 'is-featured' ]);
            }
            $pcb->setContentBox($hicTesti);
            
        endforeach; 
        
        if( isset( $elements['pe_events_footer'] ) ) {
            $pcb->setFooter( $elements['pe_events_footer'] );    
        }
    
        $pcb->displaySection();
        
        endif; wp_reset_postdata(); 
    }


		 public static function single_default_template() {

	        $testi_functions = new HI_TESTI_FUNCTIONS;

	        
	       	$testi_functions->hi_testi_details();
	
	                
	    }

	}



	new HI_TESTI_FUNCTIONS();

 ?>