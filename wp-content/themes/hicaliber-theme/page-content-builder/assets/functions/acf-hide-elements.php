<?php 
function get_element_settings(){
    $show_elements = _get_field_value('sites_elements', 'options');
    $default_el_visibility_settings = array(
        'testimonials' => array(
                'element'   => 'testimonials',
                'hidden'    => true,
                'post_types' => array(),
                'fields_selector'    => array('.acf-field-5ad9ce47f30be', // Page Section
                                            '.acf-tab-button[data-key="field_5ad9ce2af30bd"]', // Page Element Tabs
                                            '.acf-fc-popup li a[data-layout="testimonials"]' // Section Arrangement Elements
                                        ),
                'option_page'    => array()
            ),
        'gallery'   => array(
                'element' => 'gallery',
                'hidden' => true,
                'post_types' => array(),
                'fields_selector'    => array('.acf-field-5b0a409edf309', // Page Section
                                            '.acf-tab-button[data-key="field_5b0a408bdf308"]', // Page Element Tabs
                                            '.acf-fc-popup li a[data-layout="gallery"]' // Section Arrangement Elements
                                        ),
                'option_page'    => array()
            ),
        'listing_section'  => array(
                'element' => 'listing_section',
                'hidden' => true,
                'post_types' => array('property_type','booking_inspection'),
                'fields_selector'    => array('.acf-field-5ae040791db2f','.acf-field-5ad9c5af8a7e7','.acf-field-5ad9c6688a7e9', // Page Section
                                            '.acf-tab-button[data-key="field_5b0a7aeeb836b"]', // Page Element Tabs
                                            '.acf-tab-button[data-key="field_5ad9c57e8a7e6"]',
                                            '.acf-tab-button[data-key="field_5ad9c6478a7e8"]',
                                            '.acf-fc-popup li a[data-layout="listing_section_one"]', // Section Arrangement Elements
                                            '.acf-fc-popup li a[data-layout="listing_section_two"]'
                                        ),
                'option_page'    => array()
            ),
        'designs'  => array(
                'element' => 'designs',
                'hidden' => true,
                'post_types' => array('design'),
                'fields_selector'    => array(),
                'option_page'    => array()
            ),
        'team'      => array(
                'element' => 'team',
                'hidden' => true,
                'post_types' => array('team'),
                'fields_selector'    => array('.acf-field-5ab1fb7e232c4', // Page Section
                                            '.acf-tab-button[data-key="field_5ab1fb6b232c3"]', // Page Element Tabs
                                             '.acf-fc-popup li a[data-layout="team_members"]', // Section Arrangement Elements
                                             'select#page_template option[value="template-team.php"]' // Template Selector
                                        ),
                'option_page'    => array()
            ),
    );
    
    if($show_elements) {
        foreach($show_elements as $show_element) {
            $default_el_visibility_settings[$show_element]['hidden'] = false;
        }
    }
    
    return $default_el_visibility_settings;
}

add_action('acf/input/admin_head', 'hi_bt_hide_elements_fields');
 
function hi_bt_hide_elements_fields() {
    $el_visibility_settings = get_element_settings();
    
    ?>
    <style>
    <?php
    foreach($el_visibility_settings as $el_visibility_setting) {
        // Check if element is hidden
        if($el_visibility_setting['hidden']){ 
            // Hide Related ACF fields
            if($el_visibility_setting['fields_selector']){ 
                foreach($el_visibility_setting['fields_selector'] as $fields_selector){
                    if($fields_selector && $fields_selector != ''){
                        echo $fields_selector . ' { display : none; }';
                    }
                }
            }
        }
    }
    
    
    ?>
    </style>
    <?php
}
    
function hi_bt_hide_elements_cpt(){
    $el_visibility_settings = get_element_settings();
    foreach($el_visibility_settings as $el_visibility_setting) {
        // Check if element is not hidden
        
        if($el_visibility_setting['hidden']){ 
            // Show Custom Post
            if($el_visibility_setting['post_types']){ 
                foreach($el_visibility_setting['post_types'] as $post_types){
                    if($post_types){
                        unregister_post_type($post_types);
                    }
                }
            }
        }
    }
}

add_action('init','hi_bt_hide_elements_cpt', 100);

function ht_bt_remove_acf_options_page() {
    $el_visibility_settings = get_element_settings();
    foreach($el_visibility_settings as $el_visibility_setting) {
        // Check if element is not hidden
        
        if($el_visibility_setting['hidden']){ 
            // Show Custom Post
            if($el_visibility_setting['option_page']){ 
                foreach($el_visibility_setting['option_page'] as $option_page){
                    if($option_page){
                        remove_menu_page($option_page);
                    }
                }
            }
        }
    }
}

add_action('admin_init', 'ht_bt_remove_acf_options_page', 99);

?>