<?php

//add_action('wp_enqueue_scripts', 'insertHicJS',1000);

function insertHicJS() {
    wp_register_script('hic-pagination-js', get_template_directory_uri() . '/page-content-builder/assets/js/hic-pagination.js', array('jquery'), 1.0, true);
    wp_enqueue_script('hic-pagination-js');

    wp_register_script('jquery-paginate-js', get_template_directory_uri() . '/page-content-builder/assets/js/jquery.paginate.js', array('jquery'), 1.0, true);
    wp_enqueue_script('jquery-paginate-js');
    wp_register_script('jquery-simplePagination-js', get_template_directory_uri() . '/page-content-builder/assets/js/jquery.simplePagination.js', array('jquery'), 1.0, true);
    wp_enqueue_script('jquery-simplePagination-js');

    wp_register_script('hic-nice-select-js', get_template_directory_uri() . '/page-content-builder/assets/js/hic-nice-select.js', array('jquery'), 1.0, true);
    wp_enqueue_script('hic-nice-select-js');

    wp_register_script('nice-select-js', get_template_directory_uri() . '/page-content-builder/assets/js/jquery.nice-select.min.js', array('jquery'), 1.0, true);
    wp_enqueue_script('nice-select-js');

    wp_register_script('hic-lightbox-js', get_template_directory_uri() . '/page-content-builder/assets/js/hic-lightbox.js', array('jquery'), 1.0, true);
    wp_enqueue_script('hic-lightbox-js');
    wp_register_script('hic-tab-slider-js', get_template_directory_uri() . '/page-content-builder/assets/js/hic-tab-slider.js', array('jquery'), 1.0, true);
    wp_enqueue_script('hic-tab-slider-js');
    wp_register_script('loadmore-js', get_template_directory_uri() . '/page-content-builder/assets/js/loadmore.js', array('jquery'), 1.0, true);
    wp_enqueue_script('loadmore-js');
    wp_register_script('hic-gform-submit-button-js', get_template_directory_uri() . '/page-content-builder/assets/js/hic-gform-submit-button.js', array('jquery'), 1.0, true);
    wp_enqueue_script('hic-gform-submit-button-js');
}
