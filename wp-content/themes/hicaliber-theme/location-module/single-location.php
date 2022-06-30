<?php get_header(); ?>

<?php 

    $body_content_class = "";
    $show_banner = FALSE; 
    $sidebar_left = FALSE;
    $sidebar_right = FALSE;
    $sidebar_both = FALSE;

    $sidebar_options = get_field('location_sidebar','options'); 
    $banner_options = _get_field_value('location_single_banner_options', 'options'); 

    if($sidebar_options && $sidebar_options['post_sp_sidebar'] == 'has-sidebar-left' ) {
        $sidebar_left = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_sp_sidebar'];
    }
    if($sidebar_options && $sidebar_options['post_sp_sidebar'] == 'has-sidebar-right') {
        $sidebar_right = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_sp_sidebar'];
    }
    if($sidebar_options && $sidebar_options['post_sp_sidebar'] == 'has-sidebar-both') {
        $sidebar_both = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_sp_sidebar'];
    }

    $sidebar_left_widget = !empty($sidebar_options['sp_left_sidebar']) ? $sidebar_options['sp_left_sidebar'] : '';
    $sidebar_right_widget = !empty($sidebar_options['sp_right_sidebar']) ? $sidebar_options['sp_right_sidebar'] : 'sidebar2';

 ?>

<?php 

    if($banner_options == '' || $banner_options && $banner_options['show_page_banner']) {
       $show_banner = TRUE; 
    } 

    if($show_banner) :
       get_template_part('parts/content', 'hero-v2'); 
    endif;
    
?>
    
       <section class="body-content<?php echo $body_content_class; ?>">

            <div class="inner-body-content">

            <?php if( $sidebar_left || $sidebar_both ) { get_sidebar($sidebar_left_widget); } ?>
                              
                <div class="main-content">
                          
                    <div class="page-elements">
                        <div class="page-element post-content">
                            <div class="grid-container">
                                <div class="grid-x grid-padding-x">
                                    <main class="cell main" role="main">
                                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                            <?php get_template_part( 'parts/loop', 'single' ); ?>        
                                        <?php endwhile; endif; ?>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div><!-- end .page-elements -->
                </div><!-- end .main-content -->

                <?php if( $sidebar_right || $sidebar_both ) { get_sidebar( $sidebar_right_widget ); } ?>
               
          </div><!-- end .inner-body-content -->
    
    </section> <!-- end .body-content -->

   
          <?php 
        //Global Elements
        if( _have_rows('ls_sp_elements', 'options') ) : ?>
             <section class="global-element"><?php 
             while ( _have_rows('ls_sp_elements', 'options') ) : the_row(); 
                if(get_row_layout() == 'global_element'){
                    $elements['pe_g_select'] = _get_sub_field_value('pe_g_select');
                    if($elements['pe_g_select'] || $elements['pe_g_select'] === "0")
                        include( locate_template('page-content-builder/elements/content-global_element.php', false, false ) );
                }
                if(get_row_layout() == 'related') :
                    $elements['pe_locations_layout'] = _get_sub_field_value('pe_locations_layout');
                    $elements['pe_locations_design'] = _get_sub_field_value('pe_posts_design');
                    $elements['pe_locations_header'] = _get_sub_field_value('ls_sp_related_header');
                    $elements['pe_locations_content'] = _get_sub_field_value('ls_sp_related_content');
                    $elements['pe_locations_footer'] = false;
                    if(is_array($elements['pe_locations_content'])){
                        $elements['pe_locations_content']['featured'] = 'recent'; 
                        $elements['pe_locations_content']['search_filter'] = 'none'; 

                        $categories = array();

                        foreach (get_the_category() as $cat) {
                            $categories[] = $cat->term_id;
                        };

                        $elements['pe_locations_content']['categories'] = $categories;
                    }
                    include( locate_template('page-content-builder/elements/content-location.php', false, false ) );
                endif;
            endwhile;
        ?></section> <!-- end .global-element -->     
        <?php endif; ?>  
    

<?php get_footer(); ?>