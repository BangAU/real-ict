<?php 
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Display -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.23
 *
 */
    get_header(); 
    
    $body_content_class = "";
    $show_banner = FALSE; 
    $sidebar_left = FALSE;
    $sidebar_right = FALSE;
    $sidebar_both = FALSE;

    $sidebar_options = get_field('events_sidebar','options'); 

    if(is_singular('tribe_events')) {
        $banner_options = _get_field_value('events_global_banner_option', 'options');
        $sb_op_name = 'sp_sidebar';
        $l_sb_name = 'sp_left_sidebar';
        $r_sb_name = 'sp_left_sidebar';
        $pbc_name = 'events_single_page_elements';
    } elseif(tribe_is_event_query() && !is_archive()) {
        $banner_options = _get_field_value('events_ap_page_banner_option', 'options');
        $sb_op_name = 'ap_sidebar';
        $l_sb_name = 'ap_left_sidebar';
        $r_sb_name = 'ap_right_sidebar';
        $pbc_name = 'events_archive_page_elements';
    } elseif(tribe_is_event_query() && is_archive()) {
        $banner_options = _get_field_value('events_cp_page_option', 'options');
        $sb_op_name = 'cp_sidebar';
        $l_sb_name = 'cp_left_sidebar';
        $r_sb_name = 'cp_right_sidebar';
        $pbc_name = 'events_cp_page_element_builder';
    } else {
        $banner_options = _get_field_value('events_global_banner_option', 'options');
        $sb_op_name = 'sp_sidebar';
        $l_sb_name = 'sp_left_sidebar';
        $r_sb_name = 'sp_left_sidebar';
        $pbc_name = 'events_single_page_elements';
    }

    if($sidebar_options && $sidebar_options[$sb_op_name] == 'has-sidebar-left' ) {
        $sidebar_left = TRUE;
        $body_content_class .= ' '. $sidebar_options[$sb_op_name];
    }
    if($sidebar_options && $sidebar_options[$sb_op_name] == 'has-sidebar-right') {
        $sidebar_right = TRUE;
        $body_content_class .= ' '. $sidebar_options[$sb_op_name];
    }
    if($sidebar_options && $sidebar_options[$sb_op_name] == 'has-sidebar-both') {
        $sidebar_both = TRUE;
        $body_content_class .= ' '. $sidebar_options[$sb_op_name];
    }

    $sidebar_left_widget = !empty($sidebar_options[$l_sb_name]) ? $sidebar_options[$l_sb_name] : '';
    $sidebar_right_widget = !empty($sidebar_options[$r_sb_name]) ? $sidebar_options[$r_sb_name] : 'sidebar2';


    if($banner_options == '' || $banner_options && $banner_options['show_page_banner']) {
       $show_banner = TRUE; 
    } 

    if($show_banner) :
       get_template_part('/tribe-events/parts/content', 'hero'); 
    endif;
?>
<section class="body-content<?php echo $body_content_class; ?>">
    <div class="inner-body-content">
        <?php if( $sidebar_left || $sidebar_both ) { get_sidebar($sidebar_left_widget); } ?>
        <div class="main-content">
            <div class="page-elements">
                <?php get_template_part('/tribe-events/parts/content', 'tribe-events'); ?>
            </div>
        </div>
        <?php if( $sidebar_right || $sidebar_both ) { get_sidebar( $sidebar_right_widget ); } ?>
    </div>
</section>
<?php if( _have_rows($pbc_name, 'options') ) : ?>
    <section class="global-element"><?php 
        while ( _have_rows($pbc_name, 'options') ) : the_row(); 
            if(get_row_layout() == 'global_element'){
                $elements['pe_g_select'] = _get_sub_field_value('cpts_g_select');
                if($elements['pe_g_select'] || $elements['pe_g_select'] === "0")
                    include( locate_template('page-content-builder/elements/content-global_element.php', false, false ) );
            }
        endwhile;
    ?></section> <!-- end .global-element -->     
<?php endif; ?>  
<?php get_footer(); ?>