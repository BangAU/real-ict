<?php

    global $post;

    $page_id = $post->ID;

    if( is_home() ) {
        $page_id = get_option( 'page_for_posts' );
    }

    $hs = new hicaliber_theme_helpers;
    
    $post_type = _get_field_value('post_type', $page_id);
    
    $posts_per_page = _get_field_value('op_property_to_show', $page_id) ? _get_field_value('op_property_to_show', $page_id) : 9;
    
    $per_row = _get_field_value('per_row', $page_id);
    // $smooth_scroll = _get_field_value('smooth_scrolling');
    // $scroll_speed = _get_field_value('scroll_speed');
    
    $search_form_title = _get_field_value('property_search_form_title', $page_id);
    $search_form_placeholder = _get_field_value('search_filter_placeholder', $page_id);
    $show_search_bar = _get_field_value('show_property_search_form', $page_id);
    
    $no_result = _get_field_value('no_search_results', $page_id);
    
    /*************************
     * Search Filter
     *************************/
    $show_form = _get_field_value('show_search_form', $page_id);

    $sf = new hcPCBSearchFilter($search_form_title, 'testimonials_type', 'testimonials_cat', _get_field_value($post_type . '_categories', $page_id));

    
    
    if($show_form) : 
        
        if(_get_field_value('show_category_filter', $page_id)) :
            
            $sf->setCategoryFilterType(_get_field_value('category_filter_type', $page_id));

            $cat_filter_placeholder = _get_field_value('category_filter_placeholder', $page_id);
            // Set Category Filter
            if(is_array(_get_field_value($post_type . '_categories', $page_id))){
                $catOptions = $sf->getCatOptionsBy(_get_field_value($post_type . '_categories', $page_id));
            } else $catOptions = $sf->getCatOptionsBy('testimonials_cat');
            
            $sf->setFilterOptions($post_type.'_category', $catOptions, $cat_filter_placeholder);
            $sf->setFilterProperties($post_type.'_category', [
                    'name'      => $post_type.'_category',
                    'queryType' => 'tax_query',
                    'selected'  => isset($_REQUEST[$post_type.'_category']) ? $_REQUEST[$post_type.'_category'] : 'any'
                ]);
        endif;

        // Set Search filter

        if($show_search_bar) :
            $sf->setFilterOptions($post_type.'_search_field', [], '');
            $sf->setFilterProperties($post_type.'_search_field', [
                    'name'      => $post_type.'_search_field',
                    'queryType' => 'post_query',
                    'selected'  =>isset($_REQUEST[$post_type.'_search_field']) ? $_REQUEST[$post_type.'_search_field'] : '',
                    'placeholder' => $search_form_placeholder
                ]);
        endif;
        
        if(_get_field_value('show_alphabetical_filter', $page_id)) :
            
            $order_filter_placeholder = _get_field_value('alphabetical_filter_placeholder', $page_id);
            
            // Set Orderby Filter
            $sf->setFilterOptions($post_type.'_order_by', $sf->SORT_FILTER_OPTION_DEFAULT, $order_filter_placeholder);
            $sf->setFilterProperties($post_type.'_order_by', [
                    'name'      => $post_type.'_order_by',
                    'orderby'   => 'title',
                    'selected'  => isset($_REQUEST[$post_type.'_order_by']) ? $_REQUEST[$post_type.'_order_by'] : 'any'
                ]);
        endif;

        if(_get_field_value('show_date_filter', $page_id)) :
            
            $date_filter_placeholder = _get_field_value('date_filter_placeholder', $page_id);

            // Set Date filter
            $sf->setFilterOptions($post_type.'_date', $sf->DATE_FILTER_OPTION_DEFAULT, $date_filter_placeholder);
            $sf->setFilterProperties($post_type.'_date', [
                    'name'      => $post_type.'_date',
                    'queryType' => 'date_query',
                    'selected'  => isset($_REQUEST[$post_type.'_date']) ? $_REQUEST[$post_type.'_date'] : 'any'
                ]);
        endif;
    endif;

    $rel_query = $sf->getPosts();
    if(count($_REQUEST) > 0 || (count($_REQUEST) == 0 && $rel_query->have_posts()) ) : 
    $sf->displaySearchFilter($show_search_bar, $search_form_title, $search_form_placeholder);

    $content_load_method = _get_field_value('paging_type', $page_id);
    if(_get_field_value('paging_type', $page_id) == "pagination") {
        $sf->setContentLoadType('paginated');
    }
    if(_get_field_value('paging_type', $page_id) == "load_more") {
        $sf->setContentLoadType('load-more-list');
    }


    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'testimonial-element', _get_field_value('display', $page_id), _get_field_value('section_classes', $page_id), _get_field_value('theme', $page_id), _get_field_value('element_width', $page_id), _get_field_value('text_alignment', $page_id) ]
    );
    
?>

<section <?php hi_set_pageid( _get_field_value('section_id', $page_id) ); ?> class="<?php echo $section_css; ?>">

    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x hic-item-list <?php echo $sf->getContentLoadType(); ?>" id="article-content" <?php echo _get_field_value('paging_type', $page_id) == "load_more" ? 'data-per-page="'.$posts_per_page.'"' : ''; ?>>
            
                <?php 
                
                    if( $rel_query->have_posts() ) : while( $rel_query->have_posts() ) : $rel_query->the_post(); 
                    
                        $hicTesti = new hcPCBTestimonial();
                        if(_get_field_value('post_featured')) {
                            $hicTesti->setClassesOf('hic-box-container', [ 'hic-item',$per_row, 'is-featured' ]);
                        } else {
                            $hicTesti->setClassesOf('hic-box-container', ['hic-item',$per_row]);
                        }
                        
                        $hicTesti->setTitle(get_the_title());

                        $hicTesti->setContent(get_the_content() );
                        $hicTesti->setDate( get_the_date('d/m/y') );
                        $hicTesti->setRating( _get_field_value('t_rating' ) );
                        $hicTesti->setName( _get_field_value('t_name') ); 
                        $hicTesti->setLocation( _get_field_value('t_location' ) );

                        $hicTesti->setImage(new hcPCBLink( _get_field_value('t_image') ));
                        $hicTesti->setVideo( new hcPCBLink(  get_field('t_video' ) ));

                         
                        
                        $hicTesti->displayContent();
                    
                endwhile; else: $sf->displayNoResult($no_result);  endif; wp_reset_postdata(); 
                
                ?>
                
        </div>   
        
            <?php 
                /*************************
                * PAGINATION
                *************************/
                if(_get_field_value('paging_type', $page_id) == 'pagination') $sf->displayPagination($posts_per_page,$rel_query->found_posts);
                elseif(_get_field_value('paging_type', $page_id) == 'load_more')
                if( $rel_query->have_posts() ) $sf->displayLoadmore();
            ?>
        </div>
    </div>
</section>

<?php endif; ?>