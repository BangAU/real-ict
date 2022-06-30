<?php
    if( function_exists('acf_add_options_page') ) {
    
        acf_add_options_page( array( 
            'page_title' 	=> 'Post Settings',
            'parent'     => 'edit.php',
            'capability'	=> 'edit_theme_options'
        ));

    }
?>