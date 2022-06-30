<?php



if ( ! function_exists ( 'child_menu' ) ) {
    function child_menu($menu_id = ''){
     
    global $post;   

    $children = get_pages( array( 'child_of' => $post->ID ) );

    $show_childmenu = _get_field_value('opt_show_childmenu', 'options');
  
    

    $menu = '';

    $ancestor_id  =  $post->ancestors;    
    if($ancestor_id) {
        $parent_id = end($ancestor_id);
    } else {
        $parent_id = $post->ID;
    }
               
    if( is_page() && count( $children ) ) {
       $menu = wp_list_pages( array(
            'title_li'    => '',
            'child_of' => $parent_id, 
            'depth' => 1,   
            'sort_order' => 'asc',
            'skip_draft_children' => 1,
            'orderby'        => 'menu_order',
            'echo' => 0,
        ));
    }    
    if(is_page() && $post->post_parent) {
        $menu =  wp_list_pages( array(
            'title_li'    => '',
            'child_of' => $post->ID, 
            'depth' => 1,   
            'sort_order' => 'asc',
            'skip_draft_children' => 1,
            'orderby'  => 'menu_order',
            'echo' => 0,
        ));
    } 

    ?>

        
    <?php if($menu_id) :
            wp_nav_menu(array(
                'container' => false,                                               
                'menu_class' => 'menu child-page-menu',                  
                'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
                'theme_location' => 'council-portal',                                   
                'depth' => 5,                                               
                'fallback_cb' => false, 
                'walker' => new Topbar_Menu_Walker()
            ));  ?>
    <?php else : ?>
            <?php if($menu) : 

                if(!is_front_page() && $show_childmenu ) :

                    if ( (is_page() && count( $children ) > 0 || is_page() && $post_parent ) && count( $children ) != 0 ) :
                ?>  


                <div class="child-page-menu">
                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <div class="cell">
                                <ul class="menu">           
                                   <?php echo $menu; ?>
                                </ul>
                            </div>                            
                        </div>
                    </div>
                </div>

                <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
    <?php endif; ?>

    <?php }   
}

function create_child_menu( $atts ){
    return child_menu();
}

add_shortcode('child-menu', 'create_child_menu' );

?>
