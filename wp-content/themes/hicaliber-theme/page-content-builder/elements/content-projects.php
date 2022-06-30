<?php

    $pcb = new hcContentBuilder(); 

    $layout = $elements['pe_projects_layout'];
    $PCBPrj = new hcPCBProject();
    $PCBPrj->addDefaultSectionClasses($layout['display']);
    $pcb->setContentType($PCBPrj);


    $pcb->addClassesTo('section', [$layout['layout_type']]);
    if($layout['layout_type'] == 'grid') { 
        $pcb->addClassesTo('section', [$layout['grid_layout']]);
    }
    
    $id = get_the_ID();
    $include_based_on_location = [];

    // Include the based on location
    if( get_post_type() == 'location' ) {
        $include_based_on_location = [
            'key'       => 'select_locations',
            'value'     => '"'.$id.'"',
            'compare'   => 'LIKE'
        ];
    }

    $pcb->setSettings($elements['pe_projects_design']);

    //$pcb->setClassesOf('section-body', ['section-body', $layout['layout_type']]);
    $pcb->setData('item-col', $layout['per_row']);
     if($layout['slider_autoplay']) {
         $pcb->setData('autoplay', 1);
    }
    if($layout['slider_autoplay']) {
         $pcb->setData('autoplay-speed', $layout['slider_speed']);
    }

    $pcb->setHeader($elements['pe_projects_header']);
    //$pcb->setNoContentMessage("<div class='cell small-12 text-center no-result-message'><h2>No Project Available. Please try other settings.</h2></div>");

    $content_options = $elements['pe_projects_content'];
    $categories = $content_options['categories'];
    $text_to_display = $content_options['text_to_display'];
    $content_to_display = $content_options['project_content_to_display'];
    $max_word = $content_options['max_number_of_words'];

    if( is_array($content_to_display) ? !in_array('button', $content_to_display) : false || !$content_to_display ) $pcb->addClassesTo('section', ['button-hidden']);

    $listing_button_settings = _get_field_value('pjgs_action_btn_main', 'options');

    $button_label = ($listing_button_settings['label']) ? $listing_button_settings['label'] : 'Read more';
    
    $posts_per_page = $content_options['quantity'] ? $content_options['quantity'] : -1;

    if(in_array('description', $content_to_display) && $text_to_display == 'description') {
        $pcb->addClassesTo('section', 'has-description');
    }

    if(in_array('description', $content_to_display) && $text_to_display == 'excerpt') {
        $pcb->addClassesTo('section', 'has-excerpt');
    }
    
    $args = array(
        'post_type'         => 'project',
        'posts_per_page'    => $posts_per_page,
        'post_status'       => 'publish'
    );

    if($content_options['featured']=="featured") {
        $args['meta_query'] = array(
            'relation'  => 'AND',
                array(
                    'key' => 'hic_featured_post',
                    'value' => 1,
                    'compare' => '==' // not really needed, this is the default
                ),
                $include_based_on_location
        );
    } elseif ($content_options['selected_project'] && $content_options['featured'] == 'select') {
        $args['post__in'] = $content_options['selected_project'];       
    } else{
        $args['meta_query'] = array(
            'relation'  => 'AND',
                $include_based_on_location
        );
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
    }
    if($categories) 
        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'project_cat',
                'field'     => 'id', 
                'terms'     => $categories,
                'operator' => 'IN'
            )
        ); 
    
    $q = new WP_Query( $args );
    
    
    if( $q->have_posts() ) : while( $q->have_posts() ) : $q->the_post();
        
        $content = "";
        if( $text_to_display == 'excerpt' && has_excerpt() ){
            $content = wpautop( get_the_excerpt() );
        } else {
            $max_word = $text_to_display == 'description' && $max_word ? $max_word : 20;
            $content = force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop( get_the_content() ) ) , $max_word ) ) );
        }

        $hicBox = new hcPCBProject();
        $hicBox->setTitle( get_the_title() );
        if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
            $terms = get_the_terms(get_the_ID(), 'project_cat');
            if($terms && is_array($terms)) $hicBox->setTerms($terms);
        }
        if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicBox->setContent(  $content );
        $hicBox->setImage(new hcPCBLink( get_featured_image( get_the_ID() ) ));
        
        if(isset($content_options['show_gallery']) ? $content_options['show_gallery'] : false ){
            if(isset($content_options['gallery_options']) ? $content_options['gallery_options'] : false){
                $new_options = array_merge($content_options['gallery_options'], array('thumb_center_mode' => false, 'thumb_to_show' => 5, 'thumb_arrows' => false, 'thumb_dots' => true) );
                $hicBox->setGalleryOptions($new_options);
            }
            $images = _get_field_value('proj_images');
            $video = _get_field_value('proj_video');

            if($images) $hicBox->setGalleryImages($images);
            if($video) $hicBox->setVideo2(new hcPCBLink($video['youtube_video']));
        }

        $button = new hcPCBButtonElement();
        $button->constructButton(get_the_permalink(), $button_label );
        $hicBox->setButton($button);
        
        $hicBox->setClassesOf('hic-box-container', [ $layout['per_row'] ]);
         if(_get_field_value('post_featured')) {
            $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
        }
        $pcb->setContentBox($hicBox);
        
    endwhile; 
    
    if( isset( $elements['pe_projects_footer'] ) ) {
        $pcb->setFooter( $elements['pe_projects_footer'] );    
    }

    $pcb->displaySection();
    
    endif; wp_reset_postdata(); 

?>