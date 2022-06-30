<?php
	$pcb = new hcContentBuilder();

	$pcb->setContentType(new hcPCBTestimonial());

	$layout = _get_sub_field_value('cpts_testimonials_layout');
	$content = _get_field_value('proj_reviews_contents');
	$header = _get_sub_field_value('cpts_testimonials_header');
	
	$testi_header = _get_field_value('proj_reviews_heading');
	$testi_desc = _get_field_value('proj_reviews_desc');
	
	$testimonials_section_content = $content['testimonials_list'];
    $categories = $testimonials_section_content['categories'];
    
    if( $content['review_option_type']  == 'Select' ) {
        
         if( $content['testimonial_posts_id']  ) {
            $args = array(
                'post_type'         =>  'testimonials_type',
                'status'            =>  'publish',
                'order'             =>  'desc'
            );
             $args['post__in'] = $content['testimonial_posts_id'];
         }
         
    }elseif( $categories && $content['review_option_type']  == 'Category' ) {
    
        $args = array(
            'post_type'         =>  'testimonials_type',
            'status'            =>  'publish',
            'order'             =>  'desc'
        );
        
        if( $testimonials_section_content['testimonials_featured']=='featured' ){
        $args['meta_query'] =  array(
                                    'relation'  => 'AND',
                                    array(
                                        'key' => 't_list_on_homepage',
                                        'value' => 1,
                                        'compare' => '==' // not really needed, this is the default
                                    )
                                );
        }
        
        $args['posts_per_page']    =  $testimonials_section_content['testimonials_qty'];
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'testimonials_cat',
                'field'     => 'id', 
                'terms'     => $categories,
                'operator' => 'IN'
            ),
        );
    } 
         
    
	$testimonials = New WP_Query( $args );
	
	if(($testimonials->have_posts() && $content['review_option_type'] != "Script" )  || $header['peh_section_title'] || $header['peh_sub_heading'] || $testi_header || $testi_desc) :

	    $pcb->setSettings(_get_sub_field_value('cpts_testimonials_design'));
	    $pcb->addClassesTo('section', ['product-element', 'project-testimonials', $layout['testimonials_boxes_display']]);
	    $pcb->setClassesOf('section-body', [$layout['layout_type']]);
	    $pcb->setData('item-col', $layout['per_row']);

	    if( $testi_header || $testi_desc )
			$pcb->setHeader($testi_header, $testi_desc); 
		else 
			$pcb->setHeader($header); 

		if($testimonials->have_posts()) :
	
			if( $content['review_option_type'] != "Script" ) : 
				while ( $testimonials->have_posts() ) : $testimonials->the_post();

				$hicTesti = new hcPCBTestimonial();
				$hicTesti->setTitle( get_the_title() );
				// if($testimonials_section_content['full_content']) {
				// 	$hicTesti->setContent( get_the_content() );
				// } else {
				// 	$hicTesti->setContent( wp_trim_words( get_the_content(), 25, '...' ) );
				// }
				// $hicTesti->setDate( get_the_date('d/m/y') );
				$hicTesti->setContent( get_the_content() );
				$hicTesti->setRating( _get_field_value('t_rating' ) );
				$hicTesti->setName( _get_field_value('t_name') ); 
				$hicTesti->setLocation( _get_field_value('t_location' ) );  
				$hicTesti->setImage(new hcPCBLink( _get_field_value('t_image') ));
				$hicTesti->setClassesOf('hic-box-container', [$layout['per_row']]);
				$pcb->setContentBox($hicTesti);

				endwhile; 
			endif; wp_reset_postdata();
		endif;

       	$pcb->displaySection();

	endif; 
?>