<?php

    global $post;

    $page_id = $post->ID;

    if( is_home() ) {
        $page_id = get_option( 'page_for_posts' );
    }

    $hs = new hicaliber_theme_helpers;
    
    $post_type = _get_field_value('post_type', $page_id);

    $post_name_search = isset($_REQUEST[$post_type.'_search_field']) ? $_REQUEST[$post_type.'_search_field'] : '';
    $post_search_category = isset($_REQUEST[$post_type.'_category']) ? $_REQUEST[$post_type.'_category'] : 'any';
    
    $posts_per_page = _get_field_value('op_property_to_show', $page_id) ? _get_field_value('op_property_to_show', $page_id) : 9;

    $listing_button_settings = _get_field_value('pjgs_action_btn_main', 'options');

    $button_label = isset($listing_button_settings['label']) ? ($listing_button_settings['label'] ? $listing_button_settings['label'] : 'Read more') : 'Read more';
    
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

    $sf = new hcPCBSearchFilter($search_form_title, 'project', 'project_cat', _get_field_value($post_type . '_categories', $page_id));
    
    if($show_form) :

        if(_get_field_value('show_clear_filter', $page_id)) :

            $sf->setClearFilter(_get_field_value('clear_filter_label', $page_id));

        endif;
        
        if(_get_field_value('show_category_filter', $page_id)) :
            
            $sf->setCategoryFilterType(_get_field_value('category_filter_type', $page_id));
            
            $cat_filter_placeholder = _get_field_value('category_filter_placeholder', $page_id);

            // Set Filter Post Type Category
            if(is_array(_get_field_value($post_type . '_categories', $page_id))){
                $catOptions = $sf->getCatOptionsBy(_get_field_value($post_type . '_categories', $page_id));
            } else $catOptions = $sf->getCatOptionsBy('project_cat');

            // Set Category Filter
            $sf->setFilterOptions($post_type.'_category', $catOptions, $cat_filter_placeholder);
            $sf->setFilterProperties($post_type.'_category', [
                    'name'      => $post_type.'_category',
                    'queryType' => 'tax_query',
                    'selected'  => $post_search_category
                ]);
        
        endif;

        // Set Search filter
        if($show_search_bar) :
        $sf->setFilterOptions($post_type.'_search_field', [], '');
        $sf->setFilterProperties($post_type.'_search_field', [
                'name'      => $post_type.'_search_field',
                'queryType' => 'post_query',
                'selected'  => $post_name_search,
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

    global $wpdb;
    $select=[];
    $joins=[];
    $placeholder = ['publish'];
    $select[] = ['posts.ID'];
    $wheres[] = "posts.post_type = 'project'";
    $wheres[] = "AND posts.post_status = %s";
    if( $post_name_search ) {
        $post_name_search = sanitize_text_field($post_name_search);
        $wheres[] = "AND posts.post_title LIKE '%%{$post_name_search}%%'";
    }
    if( $post_search_category != 'any' ) {
        $joins[] = "INNER JOIN $wpdb->term_relationships ON (posts.ID = $wpdb->term_relationships.object_id)";
        $joins[] = "INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id AND $wpdb->term_taxonomy.taxonomy='project_cat')";
        $joins[] = "INNER JOIN $wpdb->terms ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id )";
        $wheres[] = "AND $wpdb->terms.slug='{$post_search_category}'";
    }    
    $wheres = implode(" ", $wheres);
    $joins = implode(" ", $joins);
    $sql = "SELECT DISTINCT( posts.ID ) FROM {$wpdb->prefix}posts AS posts $joins WHERE $wheres";
    $sql = trim(preg_replace('/\s+/', ' ', $wpdb->prepare( $sql , $placeholder ) )) ;
    $results = $wpdb->get_results( $sql );

if(count($_REQUEST) > 0 || (count($_REQUEST) == 0 ) ) : 
    $sf->displaySearchFilter($show_search_bar, $search_form_title, $search_form_placeholder);
    
    $content_load_method = _get_field_value('paging_type', $page_id);
    if(_get_field_value('paging_type', $page_id) == "pagination") {
        $sf->setContentLoadType('paginated');
    }
    if(_get_field_value('paging_type', $page_id) == "load_more") {
        $sf->setContentLoadType('load-more-list');
    }

    /*************************
     * SEARCH RESULTS
     *************************/
     
    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'project-element', _get_field_value('display', $page_id), _get_field_value('section_classes', $page_id), _get_field_value('theme', $page_id), _get_field_value('element_width', $page_id), _get_field_value('text_alignment', $page_id) ]
    );    
?>

<section <?php hi_set_pageid( _get_field_value('section_id', $page_id) ); ?> class="<?php echo $section_css; ?>">

    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x section-body hic-item-list <?php echo $sf->getContentLoadType(); ?>" id="hic-content" <?php echo _get_field_value('paging_type', $page_id) == "load_more" ? 'data-per-page="'.$posts_per_page.'"' : ''; ?>>
                <?php 
                    if( $results ) : 
                        foreach( $results as $result ) :
                            
                            $id = $result->ID;
                            $hicBox = new hcPCBContent();
                            $hicBox->setClassesOf('hic-box-container', ['hic-item',$per_row]);
                            $hicBox->setTitle(get_the_title( $id ));
                            
                            $content = "";
                            if(has_excerpt($id)){
                                $content = wpautop( get_the_excerpt($id) );
                            } else {
                                $content_post = get_post($id);
                                $content = wpautop($content_post->post_content);
                                $content = apply_filters('the_content', $content);
                                $content = str_replace(']]>', ']]&gt;', $content);
                                $content = force_balance_tags_trim_words( $content );
                            }
                            $hicBox->setContent( $content );

                            $hicBox->setImage( new hcPCBLink( get_featured_image( $id) ) );
                            
                            $button = new hcPCBButtonElement();
                            $button->constructButton(get_the_permalink($id), $button_label);
                            
                            $hicBox->setButton($button);

                            if(_get_field_value('post_featured',$id )) {
                                $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
                            }
                            
                            $hicBox->displayContent();
                        endforeach; 
                    else: $sf->displayNoResult($no_result);  endif;; 
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