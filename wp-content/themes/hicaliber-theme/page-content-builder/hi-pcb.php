<?php 
    if(_have_rows('page_content_builder')) : 
        
        echo '<div class="main-content"><div class="page-elements">';

         global $builder_index;
        $builder_index = 0;

        while ( _have_rows('page_content_builder') ) : the_row();
            
            /**********************
            Column Builder
            ***********************/
            if(get_row_layout() == "page_content"):
                
                $columns = _get_sub_field_value('columns');
            	include( locate_template('page-content-builder/columns/content-'.$columns['column_type'].'.php', false, false ) );
                
            endif;


            /**********************
            Element Builder
            ***********************/
            if(get_row_layout() == "page_elements"):
                
                $elements = _get_sub_field_value('elements');  
	            
	            $evh = new hcElementController( get_all_elements() );
                if($evh::isVisible($elements['page_element_selection'], false, true) || $elements['page_element_selection'] == 'gallery') :
                    
            	include( locate_template('page-content-builder/elements/content-'.$elements['page_element_selection'].'.php', false, false ) );
                
                endif; 
            endif;

            $builder_index++;
            
 	    endwhile;
        
        echo '</div></div>';

        if(get_field('page_sidebar')) :                      
            get_sidebar('general');            
        endif; 

    endif;
?>