<?php get_header();
    
    //$helper = new HI_COURSE_FUNCTIONS();

    $sidebar_left = FALSE;
    $sidebar_right = FALSE;
    $sidebar_both = FALSE;
    $body_content_class = "";
    $sidebar_options = get_field('course_sidebar', 'options');
    $banner_options = get_field('course_global_banner_option', 'options');
    $is_page_builder = get_field('gallery_pcb', 'options');


    if($sidebar_options && $sidebar_options['sp_sidebar'] == 'has-sidebar-left' ) {
        $sidebar_left = TRUE;
        $body_content_class .= ' '. $sidebar_options['sp_sidebar'];
    }
    if($sidebar_options && $sidebar_options['sp_sidebar'] == 'has-sidebar-right') {
        $sidebar_right = TRUE;
        $body_content_class .= ' '. $sidebar_options['sp_sidebar'];
    }
    if($sidebar_options && $sidebar_options['sp_sidebar'] == 'has-sidebar-both') {
        $sidebar_both = TRUE;
        $body_content_class .= ' '. $sidebar_options['sp_sidebar'];
    }

    $sidebar_left_widget = !empty($sidebar_options['sp_left_sidebar']) ? $sidebar_options['sp_left_sidebar'] : 'course_sidebar';
    $sidebar_right_widget = !empty($sidebar_options['sp_right_sidebar']) ? $sidebar_options['sp_right_sidebar'] : 'sidebar2';
    
    $is_template_page_builder = get_post_meta( get_the_ID(),  '_wp_page_template' , true ) == 'template-page-builder.php' ? true : false;

    $title = get_the_title();
    $banner_options = get_field('gallery_single_page_banner', 'options');
 ?>


<?php 
    get_template_part('parts/content', 'hero-v2');
?>

<section class="body-content<?php echo $body_content_class; ?>">

    <div class="inner-body-content">

        <?php if( $sidebar_left || $sidebar_both ) { get_sidebar($sidebar_left_widget); } ?>

            <?php
             //  if( $show_event_content ) :
            ?>

            <?php if($is_template_page_builder) : ?>
                <?php get_template_part('page-content-builder/hi', 'pcb'); ?>
            <?php else: ?>

                <?php if($is_page_builder) : ?>

                    <div class="main-content">

                        <?php if(!$banner_options['show_page_banner']) : ?>
                        <div class="grid-container page-title-container">
                             <div class="grid-x grid-padding-x">                                 
                                <h1 class="page-title"><?php echo $title; ?></h1>                        
                             </div>
                        </div>
                        <?php endif; ?> 

                                                
                             
                
                    <?php
                   
                   if(have_rows('gallery_pcb', 'options')) : 
                    
                        echo '<div class="page-elements">';

                        while ( have_rows('gallery_pcb', 'options'  ) ) : the_row();
                            
                            $get_row_layout = get_row_layout();


                            if($get_row_layout != 'global_element') :
                                                                                
                                include( locate_template('gallery-module/views/content-'.get_row_layout().'.php', false, false ) ); 
                                                              
                            endif;
                            
                            
                        endwhile;
                        
                        echo '</div>';

                    endif; ?> 

                    </div>

                <?php else: ?> 
                    <?php //$helper->single_default_template(); ?>
                <?php endif; ?>

            <?php endif; ?>
     

        <?php if( $sidebar_right || $sidebar_both ) { get_sidebar( $sidebar_right_widget ); } ?>
    </div>

</section>

<?php
    if( have_rows('gallery_pcb', 'options') && !$is_template_page_builder ) : 
    
        echo '<div class="global-elements">';

        while ( have_rows('gallery_pcb', 'options') ) : the_row();
            
            $get_row_layout = get_row_layout();


            if($get_row_layout == 'global_element') :
                
                include( locate_template('gallery-module/views/content-'.get_row_layout().'.php', false, false ) ); 
            
            endif;
            
            
        endwhile;
        
        echo '</div>';

    endif;
    ?> 
<?php get_footer(); ?>