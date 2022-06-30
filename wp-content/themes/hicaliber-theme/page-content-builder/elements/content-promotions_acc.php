<?php

    
    $pcb = new hcContentBuilder(); 
    
    

    $layout = $elements['pe_promotion_acc_layout'];
    $PCBPrj = new hcPCBAccPromotions();
    $PCBPrj->addDefaultSectionClasses($layout['display']);
    $pcb->setContentType($PCBPrj);
    

    $pcb->addClassesTo('section', [$layout['layout_type']]);
    if($layout['layout_type'] == 'grid') { 
        $pcb->addClassesTo('section', [$layout['grid_layout']]);
    }
    
    $id = get_the_ID();

    $include_based_on_location = [];


    $pcb->setSettings($elements['pe_promotions_acc_design']);

    $pcb->setClassesOf('section-body', ['section-body', $layout['layout_type']]);
    $pcb->setData('item-col', $layout['per_row']);
     if($layout['slider_autoplay']) {
         $pcb->setData('autoplay', 1);
    }
    if($layout['slider_autoplay']) {
         $pcb->setData('autoplay-speed', $layout['slider_speed']);
    }

    $pcb->setHeader($elements['pe_promotions_acc_header']);
    //$pcb->setNoContentMessage("<div class='cell small-12 text-center no-result-message'><h2>No Project Available. Please try other settings.</h2></div>");

    $content_options = $elements['pe_promotions_acc_content'];    

    $categories = $content_options['promotion_categories'];   

    //$text_to_display = $content_options['text_to_display'];
    $content_to_display = False;
    //$content_to_display = "";
    $max_word = FALSE;


   // if( is_array($content_to_display) ? !in_array('button', $content_to_display) : false || !$content_to_display ) $pcb->addClassesTo('section', ['button-hidden']);

    $listing_button_settings = get_field('property_button_label', 'options');    

    $button_label = ($listing_button_settings) ? $listing_button_settings : 'View Deals';
    
    $per_page = $content_options['quantity'] ? $content_options['quantity'] : -1;
    
    // if( $text_to_display == 'description') {
    //     $pcb->addClassesTo('section', 'has-description');
    // }

    // if( $text_to_display == 'excerpt') {
    //     $pcb->addClassesTo('section', 'has-excerpt');
    // }
    

    $query_helper = new HI_HELPER_QUERY();

        
        $args = [            
            'post_type'        => 'ac-promotions',
            'post_status'      => 'publish',
        ];        

        if( $content_options['featured'] == "select" ) {
            if( !empty( $content_options['selected_promotion'] ) )  {
                $args['post__in'] = $content_options['selected_promotion'];
                $args['per_page'] = -1;                
            }

        } else {
            $args['per_page'] = $per_page;            
        }

      


        //   // CATEGORY   
        // if( $categories ) {
            
        //     foreach($categories as $category) {
        //         if($category->term_id) array_push( $terms, $category->term_id );   
        //     }
        
        //     $args['tax_query'] = array(
        //         array(
        //             'taxonomy'  => 'ac-promotions_cat',
        //             'field'     => 'term_id', 
        //             'terms'     => $terms,
        //             'operator' => 'IN'
        //         ),
        //     ); 
        // }

        $terms = [];


            
       if($categories) 
            $args['tax_query'] = array(
            array(
                'taxonomy'  => 'ac-promotions_cat',
                'field'     => 'id', 
                'terms'     => $categories,
                'operator' => 'IN'
            )
        ); 

        // if(is_singular('ac-promotions')){
        //     $args['post__not_in'] = array($id);
        // }
        

        $query = New WP_Query( $args );

    
    if( $query->have_posts() ) : 
        
        while ( $query->have_posts() ) : $query->the_post();
        
        //Promotion ID
        $id = get_the_ID();    
        $content = "";

        $content_post = get_post($id);
        $content = $content_post->post_content;
        // $content = apply_filters('the_content', $content);
        // $content = str_replace(']]>', ']]&gt;', $content);
      

        $hicBox = new hcPCBAccPromotions();

        $hicBox->setClassesOf('hic-box-container', [ $layout['per_row']]);
        $title = get_the_title( $id );
        $promotion_title = get_the_title( $id );
        $featured_image = get_featured_image( $id );
        $link = get_the_permalink( $id );
    

            
            $featured_image = get_featured_image($id); 
            $link = get_the_permalink($id);
            $title = get_the_title($id);

           // $content = get_the_content($id);

            

            if(has_excerpt( $id )) {
                $content = get_the_excerpt($id);
            } else {
                $content = wp_trim_words( $content , 25 ) ;
            }

            
            // $main_image = get_post_meta($property, 'property_main_image', TRUE );
            // if(is_string($main_image)){
            //     $main_image = json_decode($main_image, true);
            // }
            // if($main_image) {
            //     $featured_image = $main_image['img']; 
            // }
            
            $property_state = get_field('property_state', $id);
            $property_country = get_field('property_country', $id);
                                        
            // if(get_field('property_from_price' , $property ) != '0.00') :
            //     $hicBox->setPrice(get_field('property_from_price' , $id ));
            // endif;
            
             $hicBox->setRating( get_field('property_ratings', $id ) );                                       
            

            $hicBox->setTitle( $title );
            if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
                $terms = get_the_terms( $id , 'events_cat');
                if($terms && is_array($terms)) $hicBox->setTerms($terms);
            }
            $hicBox->setContent(  $content );
            $hicBox->setImage(new hcPCBLink( $featured_image ));
    
            
            $button = new hcPCBButtonElement();
            $button->constructButton($link, $button_label );
            $hicBox->setButton($button);
            
            //$past_event_class = ( $content_options['featured'] == 'past' ) ? 'event-has-ended' : '' ;

             if(_get_field_value('post_featured')) {
                $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
            }
            $pcb->setContentBox($hicBox);

        
        
    endwhile; 
    
    if( isset( $elements['pe_properties_acc_footer'] ) ) {
        $pcb->setFooter( $elements['pe_properties_acc_footer'] );    
    }

    $pcb->displaySection();
    
    endif; wp_reset_postdata(); 

?>