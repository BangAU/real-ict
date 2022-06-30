<?php
function repeater_pre_populate_field_choices($field, $globalField){
    // reset choices
    $field['choices'] = array();
    
    // if has rows
    if( _have_rows($globalField, 'options') ) {
        
        // while has rows
        while( _have_rows($globalField, 'options') ) {
            
            // instantiate row
            the_row();
            
            // vars
            $label = _get_sub_field_value('g_elem_label') ? _get_sub_field_value('g_elem_label') : "Global Element #".get_row_index();
            $value = get_row_index() - 1;
            $element_type = _get_sub_field_value('ge_select_element');
            
            // append to choices
            $field['choices'][ $value ] = "<div class='pe-choices-container ".$value."'><img src='".ASSETS_IMG.'element-images/'.$element_type.".jpg' /><div class='element-label'>".$label."</div></div>";
            
        }
        
    }


    // return the field
    return $field;
}

function acf_load_global_elem_choices( $field ) {
    
    return repeater_pre_populate_field_choices($field, 'ge_elements');
    
}

add_filter('acf/load_field/name=pe_g_select', 'acf_load_global_elem_choices');

add_filter('acf/load_field/name=cpts_g_select', 'acf_load_global_elem_choices');


function acf_load_global_modal_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();
    
    // if has rows
    if( _have_rows('ge_modal', 'options') ) {
        
        // while has rows
        while( _have_rows('ge_modal', 'options') ) {
            
            // instantiate row
            the_row();
            
            // vars
            $label = _get_sub_field_value('g_modal_label') ? _get_sub_field_value('g_modal_label') : "Modal Element #".get_row_index();
            $value = 'modal-elem-' . (get_row_index() - 1);
            
            // append to choices
            $field['choices'][ $value ] = $label;
            
        }
        
    }


    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=data_open', 'acf_load_global_modal_choices');