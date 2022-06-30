<?php get_header(); ?>

<?php 
    
    $show_banner = FALSE; 
    $sidebar = FALSE;
    $sidebar_both = FALSE;
    $body_content_class = "";

    $sidebar_options = get_field('post_sidebar','options'); 

    if($sidebar_options && $sidebar_options['post_sp_sidebar'] != 'none' ) {
        $sidebar = TRUE;
        $body_content_class .= ' '. $sidebar_options['post_sp_sidebar'];
    }
    if($sidebar && $sidebar_options['post_sp_sidebar'] == 'has-sidebar-both') {
        $sidebar_both = TRUE;
    }

 ?>

<?php 
    
    $banner_options = _get_field_value('post_single_banner_options', 'options');

    if($banner_options == '' || $banner_options && $banner_options['show_page_banner']) {
       $show_banner = TRUE; 
    } 

    if($show_banner) :
       get_template_part('parts/content', 'hero-v2'); 
    endif;
    
?>
    
       <section class="body-content<?php echo $body_content_class; ?>">

            <div class="inner-body-content">

                <?php if( $sidebar ) { get_sidebar(); } ?>
                              
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

                <?php if( $sidebar_both ) { get_sidebar( 'secondary' ); } ?>
               
          </div><!-- end .inner-body-content -->
    
    </section> <!-- end .body-content -->

   
          <?php 
        //Global Elements
        if( _have_rows('ps_sp_elements', 'options') ) : ?>
             <section class="global-element">
         <?php while ( _have_rows('ps_sp_elements', 'options') ) : the_row(); 
                if(get_row_layout() == 'global_element'){
                    $elements['pe_g_select'] = _get_sub_field_value('pe_g_select');
                    if($elements['pe_g_select'] || $elements['pe_g_select'] === "0")
                        include( locate_template('page-content-builder/elements/content-global_element.php', false, false ) );
                }
                if(get_row_layout() == 'related') :
                    $elements['pe_posts_layout'] = _get_sub_field_value('pe_posts_layout');
                    $elements['pe_posts_design'] = _get_sub_field_value('pe_posts_design');
                    $elements['pe_posts_header'] = _get_sub_field_value('ps_sp_related_header');
                    $elements['pe_posts_content'] = _get_sub_field_value('ps_sp_related_content_option');
                    $elements['pe_posts_footer'] = false;
                    if(is_array($elements['pe_posts_content'])){
                        $elements['pe_posts_content']['recent_featured'] = 'recent'; 
                        $elements['pe_posts_content']['recent_post'] = false; 

                        $categories = array();

                        foreach (get_the_category() as $cat) {
                            $categories[] = $cat->term_id;
                        };

                        $elements['pe_posts_content']['categories'] = $categories;
                    }
                    include( locate_template('page-content-builder/elements/content-recent_posts.php', false, false ) );
                endif;
            endwhile;
        ?>    
            </section> <!-- end .global-element --> 
        <?php endif; ?>  
    

<?php get_footer(); ?>