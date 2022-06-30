<?php get_header(); ?>

<?php 
    
    $body_content_class = "";
    
    $post_sidebar_left = FALSE;
	$post_sidebar_right = FALSE;
	$post_sidebar_both = FALSE;

    $sidebar_options = get_field('location_post_sidebar','options'); 

    if($sidebar_options && $sidebar_options['post_ap_sidebar'] == 'has-sidebar-left' ) {
        $post_sidebar_left = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_ap_sidebar'];
    }
    if($sidebar_options && $sidebar_options['post_ap_sidebar'] == 'has-sidebar-right') {
        $post_sidebar_right = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_ap_sidebar'];
    }
    if($sidebar_options && $sidebar_options['post_ap_sidebar'] == 'has-sidebar-both') {
        $post_sidebar_both = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_ap_sidebar'];
    }

    $sidebar_left_widget = !empty($sidebar_options['ap_left_sidebar']) ? $sidebar_options['ap_left_sidebar'] : '';
    $sidebar_right_widget = !empty($sidebar_options['ap_right_sidebar']) ? $sidebar_options['ap_right_sidebar'] : 'sidebar2';

    global $wp_query;
    $region =  isset($wp_query->query_vars['location_post_region']) ? $wp_query->query_vars['location_post_region'] : false;

    $location_id = get_region_id($region);
    
    $elements = array();
    $elements['pe_posts_layout'] = array(
        "display"       => "image-left-content split-50-50",
        "layout_type"   => "grid",
        "grid_layout"   => "default-grid-layout",
        "per_row"       => "medium-12",
        "slider_autoplay" => false,
    );
    $elements['pe_posts_design'] = array(
        "element_width"     => "default-width",
        "text_alignment"    => "default-alignment",
        "theme"             => "default-section",
        "section_classes"   => "",
        "background_image"  => "",
        "section_id"        => "",
    );
    $elements['pe_posts_header'] = array(
        "peh_section_title" => "",
        "peh_sub_heading" => "",
    );
    $elements['pe_posts_content'] = array(
        "single_location_post_meta_options" => array(),
        "quantity"                          => 1,
        'search_filter'                     => 'none',
        'location'                          => $location_id,
    );
    $elements['pe_posts_footer'] = false; 

    
    $locationlayout = _get_field_value('design_layout', $location_id);
    
    if($locationlayout == "layout-2") :
        get_template_part('location-module/content', 'location-post-archive-hero'); 
    endif;

    ?>

<section class="body-content<?php echo $body_content_class; ?>">
        
        <div class="inner-body-content">

        <?php echo child_menu(); ?>

        <?php if($locationlayout == "layout-1") : ?>
            <?php 
            //Post Sidebar
            if( $post_sidebar_left || $post_sidebar_both ) : ?>
                <?php get_sidebar($sidebar_left_widget); ?>              
            <?php endif; ?> 

            <div class="main-content">
                <?php
                    include( locate_template('page-content-builder/elements/content-location-post.php', false, false ) );
                ?>
            </div>

            <?php 
                //Post Sidebar
            if( $post_sidebar_right || $post_sidebar_both ) : ?>
                <?php get_sidebar($sidebar_right_widget); ?>              
            <?php endif; ?> 
        <?php endif; ?>


    
        </div><!-- end .inner-body-content -->

    
        <div class="page-elements">
            <?php 
                $elements['pe_posts_layout']["display"] = "image-above-content";
                $elements['pe_posts_layout']["per_row"] = "medium-6";
                $elements['pe_posts_header']["peh_section_title"] = $locationlayout == "layout-2" ? "Latest News" : "News";
                $elements['pe_posts_content']['quantity'] = -1;

                $args = array(
                    'post_type'             => 'location_post',
                    'posts_per_page'        => 1,
                    'post_status'           => 'publish',
                );

                if( $elements['pe_posts_content']['location'] ) {
                    $args['meta_key']   = 'link_to_location';
                    $args['meta_value'] = $elements['pe_posts_content']['location'];
                } else {
                    $args['order'] = 'DESC';
                    $args['orderby'] = 'date'; 
                }
                
                $q = new WP_Query( $args );

                if($q->have_posts()): while( $q->have_posts() ) : $q->the_post(); 
                    $elements['pe_posts_content']['exclude'] = get_the_ID();
                endwhile; endif; wp_reset_postdata();

                include( locate_template('page-content-builder/elements/content-location-post.php', false, false ) ); 
            ?>
        </div>

</section> <!-- end .body-content -->

<?php get_footer(); ?>