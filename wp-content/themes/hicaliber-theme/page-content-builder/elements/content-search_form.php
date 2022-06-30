<?php 
	//variables
	$header = $elements['home_search_form_header'];
        $search_options = $elements['home_search_form_options'];

        if($search_options) {
                $search_options = implode(',', $search_options);
        } else {
                $search_options = '';
        }

        $sc_param = "";
        if(isset($elements['home_search_listing_type']))
                $sc_param .= HPLA::set_shortcode_param( 'listing', $elements['home_search_listing_type'] );
        $sc_param .= HPLA::set_shortcode_param( 'search_options', $search_options );
                $sc_param .= HPLA::set_shortcode_param( 'title', $header['peh_section_title'] );
        if(isset($elements['theme']))
                $sc_param .= HPLA::set_shortcode_param( 'theme', $elements['theme'] );
        if(isset($elements['section_classes']))
                $sc_param .= HPLA::set_shortcode_param( 'classes', $elements['section_classes'] );
        if(isset($elements['section_id']))
                $sc_param .= HPLA::set_shortcode_param( 'id', $elements['section_id'] );
        if(isset($layout['search_form_types']))
                $sc_param .= HPLA::set_shortcode_param( 'layout', $layout['search_form_types'] );
          
        echo do_shortcode('[search-widget '.$sc_param.']');  
?>