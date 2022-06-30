<?php

    
    $pcb = new hcContentBuilder(); 

    $layout = $elements['pe_courses_layout'];
    $PCBPrj = new hcPCBCourses();
    $PCBPrj->addDefaultSectionClasses($layout['display']);
    $pcb->setContentType($PCBPrj);

    $pcb->addClassesTo('section', [$layout['layout_type']]);
    if($layout['layout_type'] == 'grid') { 
        $pcb->addClassesTo('section', [$layout['grid_layout']]);
    }
    
    $id = get_the_ID();
    $include_based_on_location = [];


    $pcb->setSettings($elements['pe_courses_design']);

    $pcb->setClassesOf('section-body', ['section-body', $layout['layout_type']]);
    $pcb->setData('item-col', $layout['per_row']);
     if($layout['slider_autoplay']) {
         $pcb->setData('autoplay', 1);
    }
    if($layout['slider_autoplay']) {
         $pcb->setData('autoplay-speed', $layout['slider_speed']);
    }

    $pcb->setHeader($elements['pe_courses_header']);
    $content_options = $elements['pe_courses_content'];    

    $categories = $content_options['categories'];

    $text_to_display = $content_options['text_to_display'];
    $content_to_display = $content_options['course_content_to_display'];
    //$content_to_display = "";
    $max_word = $content_options['max_number_of_words'];


    if( is_array($content_to_display) ? !in_array('button', $content_to_display) : false || !$content_to_display ) $pcb->addClassesTo('section', ['button-hidden']);

    $listing_button_settings = _get_field_value('pjgs_action_btn_main', 'options');

    $button_label = (isset($listing_button_settings['label']) ? $listing_button_settings['label'] : false) ? $listing_button_settings['label'] : 'View course';
    
    $per_page = $content_options['quantity'] ? $content_options['quantity'] : -1;

    if( $text_to_display == 'description') {
        $pcb->addClassesTo('section', 'has-description');
    }

    if( $text_to_display == 'excerpt') {
        $pcb->addClassesTo('section', 'has-excerpt');
    }
    
    $post_name_search = '';
    
    if( class_exists('HI_COURSE_FUNCTIONS') ) {
        
        $param = [
            'post_name_search'  => $post_name_search,
            'event_data'        => $content_options,
            'per_page'          => $per_page
        ];
        
        if( !empty( $categories ) ) {
           $categories =  implode( "','",  $categories );
           $categories = "('{$categories}')";   
           $param['cpt_category'] = "course_cat";
           $param['term_search'] = "term_id";
           $param['scl'] =  $categories;
        }
        
    
        
        $results = HI_COURSE_FUNCTIONS::course( $param );



    }

    $result_count = sizeof( $results );



    
    if(  $result_count ) :
        
        foreach( $results as  $result  ):  
        $id = $result->ID;    
        
        $content = "";

        if( $text_to_display == 'excerpt' && has_excerpt( $id ) ){
            $content = wpautop( get_the_excerpt( $id ) );
        } else {
            $max_word = $text_to_display == 'description' && $max_word ? $max_word : 35;
            $content = wp_trim_words( get_the_content( $id ) , $max_word ) ;
        }

        $hicBox = new hcPCBCourses();
        $hicBox->setClassesOf('hic-box-container', [ $layout['per_row'] ]);
        $hicBox->setTitle( get_the_title( $id ) );        

        if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
            $terms = get_the_terms( $id , 'course_cat');
            if($terms && is_array($terms)) $hicBox->setTerms($terms);
        }

        if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicBox->setContent(  $content );
        $hicBox->setImage(new hcPCBLink( get_featured_image( $id ) ));
        
        if(isset($content_options['show_gallery']) ? $content_options['show_gallery'] : false ){
            if(isset($content_options['gallery_options']) ? $content_options['gallery_options'] : false){
                $new_options = array_merge($content_options['gallery_options'], array('thumb_center_mode' => false, 'thumb_to_show' => 5, 'thumb_arrows' => false, 'thumb_dots' => true) );
                $hicBox->setGalleryOptions($new_options);
            }
            $images = _get_field_value('proj_images' , $id);
            $video = _get_field_value('proj_video', $id);

            if($images) $hicBox->setGalleryImages($images);
            if($video) $hicBox->setVideo2(new hcPCBLink($video['youtube_video']));
        }


        // if( is_array($content_to_display) ? in_array('date_time', $content_to_display) : false ) {
        //    $hicBox->setDate(get_field('event_time' , $id ));
        // }
        //$hicBox->setPrice(get_field('price' , $id ));
        
        $button = new hcPCBButtonElement();
        $button->constructButton(get_the_permalink( $id ), $button_label );
        $hicBox->setButton($button);
        
        //$past_event_class = ( $content_options['featured'] == 'past' ) ? 'event-has-ended' : '' ;
        
         if(_get_field_value('post_featured')) {
            $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
        }
        $pcb->setContentBox($hicBox);
        
    endforeach; 
    
    if( isset( $elements['pe_courses_footer'] ) ) {
        $pcb->setFooter( $elements['pe_courses_footer'] );    
    }

    $pcb->displaySection();
    
    endif; wp_reset_postdata(); 

?>