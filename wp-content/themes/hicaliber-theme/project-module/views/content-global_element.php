<?php
    // set PCB Selection element
    $selected_element = _get_sub_field_value('cpts_g_select');
    
    // Check if there is global element
    if( _have_rows('ge_elements', 'options') ) {
        
        // check for selected element while there is global element
        while( _have_rows('ge_elements', 'options') ) { the_row();
            
            if(get_row_index() - 1 == $selected_element){
                
                // Set element with global element detail if element matched the selection
                
                $element_type = _get_sub_field_value('ge_select_element');
                $elements = NULL;
                switch($element_type){
                    case "call_to_Action" :
                        if(_get_sub_field_value('ge_cta')) $elements = _get_sub_field_value('ge_cta'); 
                    break;
                    case "contact_form" :
                        if(_get_sub_field_value('ge_form')) $elements = _get_sub_field_value('ge_form');
                    break;
                    case "content_boxes" :
                        if(_get_sub_field_value('ge_content_boxes')) $elements = _get_sub_field_value('ge_content_boxes');
                    break;
                    default:
                    break;
                }

            	include( locate_template('page-content-builder/elements/content-'.$element_type.'.php', false, false ) );
            }
        }
        
    }

?>