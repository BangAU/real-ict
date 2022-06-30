<?php 
    
    $body_content_class = "";
    
    $post_sidebar_display = _get_field_value('show_post_sidebar', 'options');
    $post_sidebar_content_location = _get_field_value('post_sidebar_content_location', 'options');
    $post_sidebar_location = _get_field_value('post_sidebar_location', 'options');

    $post_type = _get_field_value('post_type');


    $post_sidebar_left = FALSE;
	$post_sidebar_right = FALSE;
	$post_sidebar_both = FALSE;

    if($post_type == 'posts') {

         $sidebar_options = get_field('post_sidebar','options'); 

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
    }


    $product_sidebar = FALSE;
    $product_sidebar_both = FALSE; 

    // If Products Plugin Activated
    if( $post_type == 'products' && class_exists('HI_PRODUCTS') ) {
    
        $product_sidebar_options = get_field('product_sidebar','options');
    
        if($product_sidebar_options && $product_sidebar_options['prod_ap_sidebar'] != 'none' ) {
            $product_sidebar = TRUE;
            $body_content_class .= ' '. $product_sidebar_options['prod_ap_sidebar'];
        }
        if($product_sidebar && $product_sidebar_options['prod_ap_sidebar'] == 'has-sidebar-both') {
            $product_sidebar_both = TRUE;
        }
    }
    
     ?>

<section class="body-content<?php echo $body_content_class; ?>">
        
        <div class="inner-body-content">

        <?php echo child_menu(); ?>

        
        <?php 
            //Product Sidebar
            if( $post_type == 'products' && $product_sidebar ) {
                get_product_sidebar();
            }            
         ?>
        <?php 
            //Post Sidebar
        if( $post_type == 'posts' && ($post_sidebar_left || $post_sidebar_both)  ) : ?>
            <?php get_sidebar($sidebar_left_widget); ?>              
        <?php endif; ?> 
    
         <div class="main-content">
            <?php if(_have_rows('page_content_builder') || $post_type) : ?>
            
            
                <?php
                    $cpt_main_content = get_field('cpt_display_main_conent')
                ?>
                
                <?php if($cpt_main_content) : ?>         
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                   <section class="page-element page-content default-section">
                       <div class="inner-section">
                           <div class="grid-container">
                               <div class="grid-x grid-padding-x">
                                   <div class="cell"><?php the_content(); ?></div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endwhile; endif; ?>
                <?php endif; ?>
            
                <?php 
                
                    if($post_type == 'events' ) {
                        if(class_exists('HI_EVENTS')) {
                            get_template_part('page-content-builder/elements/content-cpt-sf', 'events');
                        }
                    } else {
                        get_template_part('page-content-builder/elements/content-cpt-sf', $post_type);
                    }
                        
                ?>
                
                
            <?php endif; ?>
        </div>
        
         <?php 
            if( $post_type == 'posts' && $post_sidebar_both ) {
                get_sidebar( 'secondary' );
            }            
         ?>

        <?php 
            //Post Sidebar
        if( $post_type == 'posts' && ($post_sidebar_right || $post_sidebar_both)  ) : ?>
            <?php get_sidebar($sidebar_right_widget); ?>              
        <?php endif; ?> 

         <?php 
            if( $post_type == 'products' && $product_sidebar_both ) {
                get_sidebar( 'secondary' );
            }            
         ?>


    
        </div><!-- end .inner-body-content -->

    
        <div class="page-elements"><?php 
            if( _have_rows('page_content_builder') ) : while ( _have_rows('page_content_builder') ) : the_row();            
                /**********************
                Column Builder
                ***********************/
                if(get_row_layout() == "page_content"):
                    
                    $columns = _get_sub_field_value('columns');
                    include( locate_template('page-content-builder/columns/content-'.$columns['column_type'].'.php', false, false ) );
                    
                endif;
                /**********************
                Element Builder
                ***********************/
                if(get_row_layout() == "page_elements"):
                    
                    $elements = _get_sub_field_value('elements');                       
                    $evh = new hcElementController(_get_field_value('sites_elements', 'options'));

                        if($evh::isVisible($elements['page_element_selection'], false, true) || $elements['page_element_selection'] == 'gallery') :
                                
                            include( locate_template('page-content-builder/elements/content-'.$elements['page_element_selection'].'.php', false, false ) );
                            
                        endif; 
                endif;                    
            endwhile; endif; 
        ?></div>

</section> <!-- end .body-content -->