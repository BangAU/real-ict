<?php
/*************************************************************/
/*   Friendly Block Titles                                  */
/***********************************************************/
 
function content_builder_section_title($title, $field, $layout, $i) {
	if($value = _get_sub_field_value('layout_title')) {
		$title = $value;
	} else {
		foreach($layout['sub_fields'] as $sub) {
			if($sub['name'] == 'layout_title') {
				$key = $sub['key'];
				if(is_array($field['value'])){
				    if(array_key_exists($i, $field['value']) && $value = $field['value'][$i][$key])
					    $title = $value;   
				}
			}
		}
	}

	if(get_row_layout() == "page_elements") $element = _get_sub_field_value('elements')['page_element_selection'];
	else $element = false;

	if($element){

		$evh = new hcElementController( get_all_elements() );
		
	    if(!$evh::isVisible($element, false, true) && $element != 'gallery'){
	    	$title = '<span class="disabled_element">'.$element.' is disabled, require content updates!</span>';
	    }
	}

	return  $title;
}
add_filter('acf/fields/flexible_content/layout_title', 'content_builder_section_title', 10, 4);