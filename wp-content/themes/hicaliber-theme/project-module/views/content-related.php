<?php
    
 	$feature_project_list = _get_field_value('proj_related_projects');
 	$related_project_heading = _get_field_value('proj_related_heading');
	$related_project_blurb = _get_field_value('proj_related_desc'); 
	
	$new_array_set = [];
	if(is_array($feature_project_list)){
		foreach($feature_project_list as $projs_selected){
			if(is_array($projs_selected) ? count($projs_selected) > 0 : false ) foreach($projs_selected as $proj){
				array_push($new_array_set, $proj);
			}
		}
	}

	if(_get_field_value('proj_related_display')) :
     
        echo $pv::generate_projects_listing( $related_project_heading , $related_project_blurb, array($new_array_set), 'related-projects' ); 
    
    endif;
?>