<?php

function search_form( $params = [] ){

    /*
        <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
            <label>
                <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'jointswp' ) ?></span>
                <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search...', 'jointswp' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'jointswp' ) ?>" />
            </label>
            <input type="submit" class="search-submit button" value="<?php echo esc_attr_x( 'Search', 'jointswp' ) ?>" />
        </form>
    */


    extract($params);
    $the_name = 's';
    $url=home_url('/');
    if( $pageid ) {
        $url = get_permalink($pageid);
        $the_name = 'posts_search_field';
    }
    
    if($search) {
        $the_name = $search;
    }

    $html = "<form class='search-form' method='GET' action='{$url}'>";
    $html .= "<div class='input-group'>";
    $html .= "<input type='text' name='{$the_name}' autocomplete='off' placeholder='{$placeholder}' value=''>";
    
    if( $type ) {        
        $html .= "<input type='hidden' name='type' value='{$type}'>";
    }
        $html .= "<input type='submit' class='search-submit button' value='{$label}' />";
    $html .= "</div>";
    $html .= "</form>";
    return $html;
}

function create_search_form( $atts ){
    $a = shortcode_atts( array(
        'pageid'       => '',
        'placeholder'   => 'Search...',
        'type'          => '',
        'search'          => '',
        'label'         => "Search",        
    ), $atts ); 

    return search_form( $a );
}
add_shortcode('search-post', 'create_search_form' );