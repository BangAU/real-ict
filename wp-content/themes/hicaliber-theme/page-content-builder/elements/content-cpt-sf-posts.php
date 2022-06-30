<?php

    global $post;

    $page_id = $post->ID;
    
    if( is_home() ) {
        $page_id = get_option( 'page_for_posts' );
    }

    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();
    
    $post_type = _get_field_value('post_type', $page_id);
    
    $posts_per_page = _get_field_value('op_property_to_show', $page_id) ? _get_field_value('op_property_to_show', $page_id) : 9;
    
    $per_row = _get_field_value('per_row', $page_id);
    // $smooth_scroll = _get_field_value('smooth_scrolling');
    // $scroll_speed = _get_field_value('scroll_speed');
    
    $search_form_title = _get_field_value('property_search_form_title', $page_id);
    $search_form_placeholder = _get_field_value('search_filter_placeholder', $page_id);
    $show_search_bar = _get_field_value('show_property_search_form', $page_id);
    
    $no_result = _get_field_value('no_search_results', $page_id);
    
    $post_meta_options = _get_field_value('post_meta_options', $page_id);
    
    $cpt_header = get_field('cpt_content_header', $page_id);
    
    /*************************
     * Search Filter
     *************************/
    $show_form = _get_field_value('show_search_form', $page_id);
    
    
    $selected_cat_posts = _get_field_value($post_type . '_categories', $page_id);
    $selected_categories = isset($_REQUEST[$post_type.'_category']) ? $_REQUEST[$post_type.'_category'] : 'any';
    
    if( 'any' != $selected_categories &&  $selected_categories != ""  ) {
        $selected_categories_array = explode(',',$selected_categories );
        if( is_array( $selected_categories_array ) ) {
            $selected_categories = $selected_categories_array;
        }
    }    

    if( $selected_categories == "" ) {
        $selected_categories = "any";
    }
    
    if( class_exists('HI_PORTAL') ) {
        $selected_cat_posts = HI_PORTAL::get_selected_posts_id($selected_cat_posts);         
    } else {
        
    }
    

    $sf = new hcPCBSearchFilter($search_form_title, 'post', 'category', $selected_cat_posts);
    
   
    
    if($show_form) : 
        
        if(_get_field_value('show_clear_filter', $page_id)) :

            $sf->setClearFilter(_get_field_value('clear_filter_label', $page_id));

        endif;
        
        if(_get_field_value('show_category_filter', $page_id)) :
            
             $sf->setCategoryFilterType(_get_field_value('category_filter_type', $page_id));
            
            $cat_filter_placeholder = _get_field_value('category_filter_placeholder', $page_id);
            
            // Set Category Filter
            if(is_array($selected_cat_posts)){
                $catOptions = $sf->getCatOptionsBy($selected_cat_posts);
            } else $catOptions = $sf->getCatOptionsBy('category');
            
            $sf->setFilterOptions($post_type.'_category', $catOptions, $cat_filter_placeholder);
          
            $sf->setFilterProperties($post_type.'_category', [
                    'name'      => $post_type.'_category',
                    'queryType' => 'tax_query',
                    'selected'  => $selected_categories
                ]);
            
        endif;
        
        // Set Search filter
        if($show_search_bar) :
            $sf->setFilterOptions($post_type.'_search_field', [], '');
            $sf->setFilterProperties($post_type.'_search_field', [
                    'name'      => $post_type.'_search_field',
                    'queryType' => 'post_query',
                    'selected'  => isset($_REQUEST[$post_type.'_search_field']) ? $_REQUEST[$post_type.'_search_field'] : '',
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
    if(count($_REQUEST) > 0 || count($_REQUEST) == 0 ) : 
    //$sf->displaySearchFilter($show_search_bar, $search_form_title, $search_form_placeholder);

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
       [ 'page-element', 'post-element', 'listing-element', _get_field_value('display', $page_id), 'grid', _get_field_value('cpt_grid_layout', $page_id), _get_field_value('section_classes', $page_id), _get_field_value('theme', $page_id), _get_field_value('element_width', $page_id), _get_field_value('text_alignment', $page_id) ]
    );

    $qry = new HI_HELPER_QUERY();

    $args = array(
        "post_type" => "post",
        "per_page" => $posts_per_page,
        "post_status" => "publish",
    );

    $post_category = !empty($_GET["posts_category"]) && $_GET["posts_category"] != "any" ? esc_attr($_GET["posts_category"]) : "";

    if(!empty($post_category)):
        $category = get_term_by("slug", $post_category, "category");
        if($category):
            $args["tax_query"][] = array(
                "taxonomy"  => "category",
                "field" => "term_id",
                "operator"  => "=",
                "terms" => $category->term_id
            );
        endif;
    endif;
    
    $results = $qry->qry($args);

?>

<section <?php hi_set_pageid( _get_field_value('section_id', $page_id) ); ?> class="<?php echo $section_css; ?>">

    <div class="inner-section">
        <div class="grid-container">
            
            <?php $pcb->printHeader($cpt_header); ?>
            
             <div class="grid-x grid-padding-x section-search-form">
                <?php 
                        $sf->displaySearchFilterV2($show_search_bar, $search_form_title, $search_form_placeholder);
                ?>
                </div>
            
            <div class="grid-x grid-padding-x section-body grid article-list <?php echo $sf->getContentLoadType(); ?>" id="article-content" <?php echo _get_field_value('paging_type', $page_id) == "load_more" ? 'data-per-page="'.$posts_per_page.'"' : ''; ?>>
            
                <?php 
                
                    if( isset( $results['data'] ) ) {

                        foreach( $results['data'] as $id ) {
                    
                        $hicArticle = new hcPCBArticle();
                        $hicArticle->setClassesOf('hic-box-container', ['hic-item',$per_row]);
                        $hicArticle->setTitle(get_the_title($id));

                        $content = wp_trim_words(get_the_content(null, false, $id), 20, '...');

                        if(has_excerpt()) {
                            $content = get_the_excerpt($id);
                        }
 
                        $hicArticle->setContent($content);
                        $hicArticle->setImage(new hcPCBLink(get_featured_image( $id )));
                        
                        $hicArticle->setDate( get_the_date( 'F j, Y', $id ) );
                        $hicArticle->setAuthor( get_the_author() );
                        $hicArticle->setCategoryList( get_the_category_list(', ') );

                        $hicArticle->setMetaOption($post_meta_options);                        
                            
                        $button = new hcPCBButtonElement();
                        $button->constructButton(get_the_permalink($id), "Read more");
                        
                        $hicArticle->setButton($button);
                        
                        if(_get_field_value('post_featured')) {
                            $hicArticle->setClassesOf('hic-box', [ 'is-featured' ]);
                        }
                        
                        $hicArticle->displayContent();
                    }
                }else{
                     $sf->displayNoResult($no_result);
                }
                
                ?>
                
            </div>   
       
            <?php 
                /*************************
                * PAGINATION
                *************************/
                if(_get_field_value('paging_type', $page_id) == 'pagination'){
                    if( isset( $results['pager'] ) ) {
                        echo "<div class='cell pager-column hic-pagination'><div class='wp-pager'>".$results['pager']."</div></div>";
                    }
                } //$sf->displayPagination($posts_per_page,$rel_query->found_posts);
                elseif(_get_field_value('paging_type', $page_id) == 'load_more'){
                    //if( $rel_query->have_posts() ) $sf->displayLoadmore();   
                    //need TEST 
                    if(isset($results["data"]) && count($results["data"]) > 0) $sf->displayLoadmore(); 
                }
                
            ?>
        </div>
    </div>
</section>
<?php endif; wp_reset_postdata(); ?>