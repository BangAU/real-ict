<?php
    $testimonials_section_content = $elements['testimonials_section_content'];
    $categories = $testimonials_section_content['categories'];
    $layout = $elements['testimonials_section_layout'];
    
    $posts_per_page = $testimonials_section_content['testimonials_qty'] ? $testimonials_section_content['testimonials_qty'] : -1;
                                    
    $args = array(
        'posts_per_page'    =>  $posts_per_page,
        'post_type'         =>  'testimonials_type',
        'status'            =>  'publish',
        'order'             =>  'desc'
        
    );
    if($testimonials_section_content['testimonials_featured']=='featured'){
        $args['meta_query'] =  array(
                                    'relation'  => 'AND',
                                    array(
                                        'key' => 'post_featured',
                                        'value' => 1,
                                        'compare' => '==' // not really needed, this is the default
                                    )
                                );
    }
    if($categories) 
         $args['tax_query'] = array(
            array(
                'taxonomy'  => 'testimonials_cat',
                'field'     => 'id', 
                'terms'     => $categories,
                'operator' => 'IN'
            ),
        );
        
    if ($testimonials_section_content['selected_testimonial'] && $testimonials_section_content['testimonials_featured'] == 'select') {
        $args['post__in'] = $testimonials_section_content['selected_testimonial'];       
    }
    
    $testimonials = New WP_Query( $args );

    if( $testimonials->have_posts() ) : 

        $pcb = new hcContentBuilder(); 
        $PCBPrj = new hcPCBTestimonial();
        $PCBPrj->addDefaultSectionClasses($layout['testimonials_boxes_display']);
        $pcb->setContentType($PCBPrj);



        $pcb->addClassesTo('section', [$layout['layout_type']]);

        if($layout['layout_type'] == 'grid') {
            $pcb->addClassesTo('section', [$layout['grid_layout']]);
        }
        
        $pcb->setSettings($elements['testimonials_section_design']);
        $pcb->setData('item-col', $layout['per_row']);
        $pcb->setData('full-content', $testimonials_section_content['full_content']);
        if($layout['slider_autoplay']) {
             $pcb->setData('autoplay', 1);
        }
        if($layout['slider_autoplay']) {
             $pcb->setData('autoplay-speed', $layout['slider_speed']);
        }
        $pcb->setHeader($elements['testimonials_section_header']);
        
        while ( $testimonials->have_posts() ) : $testimonials->the_post();

            $video_testi = get_field('t_video');

            $hicTesti = new hcPCBTestimonial();

            $hicTesti->setTitle( get_the_title() );
            $hicTesti->setClassesOf('hic-box-container', [$layout['per_row']]);            
            if($testimonials_section_content['full_content']) {
                $hicTesti->setContent( get_the_content() );
            } else {
                $hicTesti->setContent( wp_trim_words( get_the_content(), 25, '...' ) );
            }
            // $hicTesti->setDate( get_the_date('d/m/y') );
            $hicTesti->setRating( _get_field_value('t_rating' ) );
            $hicTesti->setName( _get_field_value('t_name') ); 
            $hicTesti->setLocation( _get_field_value('t_location' ) );  
            $hicTesti->setImage(new hcPCBLink( _get_field_value('t_image') ));
            $hicTesti->setVideo( new hcPCBLink(  $video_testi ) );
            
            if(_get_field_value('post_featured')) {
                $hicTesti->setClassesOf('hic-box', [ 'is-featured' ]);
            }
            $pcb->setContentBox($hicTesti);             
                        
        endwhile; 

        $pcb->setFooter($elements['testimonials_section_footer']);

        $pcb->displaySection();

    endif; 
    wp_reset_postdata(); 
?>