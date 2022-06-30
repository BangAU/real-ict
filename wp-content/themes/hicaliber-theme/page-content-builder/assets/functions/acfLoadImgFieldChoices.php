<?php 
function acf_load_pe_field_choices( $field ) {

    $evh = new hcElementController( get_all_elements() );
    $field['choices'] = array();

    $allVisible = $evh::getAllElements(false, true, true);
    if( !in_array('gallery', $allVisible) ){
        $allVisible[] = 'gallery';
    }
    if( is_array($allVisible) ) {
        
        foreach( $allVisible as $choice ) {

            $label = $evh::getProperty($choice, 'label');
            
            $field['choices'][$choice] = "<div class='pe-choices-container ".$choice."'><img src='".ASSETS_IMG.'element-images/'.$choice.".jpg' /><div class='element-label'>".$label."</div></div>";

        }
        
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=page_element_selection', 'acf_load_pe_field_choices');

function acf_load_se_field_choices( $field ) {
                
    // reset choices
    $evh = new hcElementController( array( 'faq', 'contact_form', 'gallery', 'location', 'projects',
        'recent_posts', 'social_feeds', 'team', 'testimonials', 'code_element') );
    
    $field['choices'] = array();

    $allVisible = $evh::getAllElements(true);
    if( is_array($allVisible) ) {
        foreach( $allVisible as $choice ) {
            $label = $evh::getProperty($choice, 'label');            
            $field['choices'][$choice] = "<div class='pe-choices-container ".$choice."'><img src='".ASSETS_IMG.'element-images/'.$choice.".jpg' /><div class='element-label'>".$label."</div></div>";
        }
        
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=sites_elements', 'acf_load_se_field_choices');

function acf_load_pge_field_choices( $field ) {
    
    // reset choices
    $default_elems = array('call_to_Action', 'contact_form', 'content_boxes');
    if(hcElementController::isVisible('code_element')){
        array_push($default_elems, 'code_element');
    }
    if(hcElementController::isVisible('testimonials')){
        array_push($default_elems, 'testimonials');
    }
    if(hcElementController::isVisible('recent_posts')){
        array_push($default_elems, 'recent_posts');
    }
    if(hcElementController::isVisible('gallery')){
        array_push($default_elems, 'gallery');
    }
    $evh = new hcElementController( $default_elems );
    $field['choices'] = array();

    $allVisible = $evh::getAllElements(true);
	if( is_array($allVisible) ) {
        
        foreach( $allVisible as $choice ) {
            $label = $evh::getProperty($choice, 'label');
            
            $field['choices'][$choice] = "<div class='pe-choices-container ".$choice."'><img src='".ASSETS_IMG.'element-images/'.$choice.".jpg' /><div class='element-label'>".$label."</div></div>";
        }
        
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=ge_select_element', 'acf_load_pge_field_choices');

function acf_rb_load_pcb_column_type( $field ) {
    // reset choices
    $field['choices'] = array();
    $choices = array(
                    array('full-column', '1/1 Column'),
                    array('two-columns', 'Two 1/2 Column'),
                    array('three-columns', 'Three 1/3 Column'),
                    array('four-columns', 'Four 1/4 Column'),
                    array('columns-8-4', '2/3 & 1/3 Column'),
                    array('columns-4-8', '1/3 & 2/3 Column'),
                    array('columns-9-3', '3/4 & 1/4 Column'),
                    array('columns-3-9', '1/4 & 3/4 Column')
                );

    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
        //$choice = 'gallery';
        $field['choices'][$choice[0]] = "<div class='pe-choices-container ".$choice[0]."'><img src='".ASSETS_IMG.'element-images/'.$choice[0].".jpg' /><div class='element-label'>".$choice[1]."</div></div>";
        }
    }
    // return the field
    return $field;
}

add_filter('acf/load_field/name=column_type', 'acf_rb_load_pcb_column_type');