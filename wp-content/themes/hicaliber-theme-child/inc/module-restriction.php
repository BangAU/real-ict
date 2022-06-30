<?php 
function aipm_allowed_block_types($allowed_block_types, $post) {

    //default modules
    $allowed_block_types = array(
        //adding core modules
        'core/block',
        // 'core/image',
        // 'core/html',
        // 'core/video',
        // 'core/youtube',
        // 'core/vimeo',
        // 'core/column',
    );
    // Intended to restrict to just one block on my homepage template but does not
if ( is_page_template('template_landing.php') ) {
    $allowed_block_types= array( 
        'acf/contact-form',
        'acf/header-banner',
        'acf/left-or-right-text-image',
        'acf/list',
        'acf/text-and-image'
    );
}
    
   


    return $allowed_block_types;
}

add_filter( 'allowed_block_types', 'aipm_allowed_block_types', 10, 2);

?>