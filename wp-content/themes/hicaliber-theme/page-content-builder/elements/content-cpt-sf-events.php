<?php

    global $post;

    $page_id = $post->ID;
    
    if( is_home() ) {
        $page_id = get_option( 'page_for_posts' );
    }

    $catOptions = "";

    $cpt_category = 'events_cat';

    $hs = new hicaliber_theme_helpers;
    
    $post_type = _get_field_value('post_type', $page_id);
    
    $posts_per_page = _get_field_value('op_property_to_show', $page_id) ? _get_field_value('op_property_to_show', $page_id) : 9;
    
    $per_row = _get_field_value('per_row', $page_id);
    $theme = _get_field_value('theme', $page_id);
    
    $grid_layout = get_field('cpt_grid_layout');


    $search_form_title = _get_field_value('property_search_form_title', $page_id);
    $search_form_placeholder = _get_field_value('search_filter_placeholder', $page_id);
    $show_search_bar = _get_field_value('show_property_search_form', $page_id);
    
    $no_result = _get_field_value('no_search_results', $page_id);
    
    $post_meta_options = _get_field_value('post_meta_options', $page_id);
    
    /*************************
     * Search Filter
     *************************/
    $show_form = _get_field_value('show_search_form', $page_id);
    
    $selected_cat_posts = _get_field_value($post_type . '_categories', $page_id);
    $selected_categories = isset($_REQUEST[$post_type.'_category']) ? $_REQUEST[$post_type.'_category'] : 'any';
    $post_name_search = isset( $_GET['events_search_field'] ) ? $_GET['events_search_field'] : "";

    
    $sf = new hcPCBSearchFilter($search_form_title, 'events', $cpt_category, $selected_cat_posts);    
    
    if($show_form) : 
        if(_get_field_value('show_clear_filter', $page_id)) :

            $sf->setClearFilter(_get_field_value('clear_filter_label', $page_id));

        endif;
        
        if(_get_field_value('show_category_filter', $page_id)) :
            
            $cat_filter_placeholder = _get_field_value('category_filter_placeholder', $page_id);
            
            // Set Category Filter
            if(is_array($selected_cat_posts)){
                $catOptions = $sf->getCatOptionsBy($selected_cat_posts);
            } else $catOptions = $sf->getCatOptionsBy($cpt_category);
            
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
    
    
    $scl = "";

    if( 'any' != $selected_categories &&  $selected_categories != ""  ) {
        $selected_categories_array = explode(',',$selected_categories );
        $scl =  implode("','",$selected_categories_array );
        $scl = "('{$scl}')";        
    } else {        
        if( $catOptions ) {
            $scl = array();
            foreach( $catOptions AS $cat ) {
                $scl[] = $cat['val'];
            }
            $scl =  implode("','",$scl);
            $scl = "('{$scl}')";            
        }
        // $selected_categories = 
    }

    if( class_exists('HI_PORTAL') ) {
        $selected_cat_posts = HI_PORTAL::get_selected_posts_id($selected_cat_posts);         
    } 

    $results = [];
    $result_count = 0;

    
    $post_search_category = $selected_categories;
    
    //var_dump(get_field('cpt_events_listing_display'));
    
    $content_options = array();
    
    $content_options['featured'] = get_field('cpt_events_listing_display');
    
    $content_options['event_content_to_display'] = get_field('cpt_event_content_to_display');
    
    $content_options['text_to_display'] = get_field('cpt_event_text_to_display');
    
    $content_options['max_number_of_words'] = get_field('cpt_event_max_number_of_words');
    
    
    $content_options['paginate'] = _get_field_value('paging_type', $page_id);
    
    if( class_exists('HI_EVENTS_FUNCTIONS') ) {
        $param = [
            'per_page'          => $posts_per_page,    
            'post_name_search'  => $post_name_search,
            'scl'               => $scl,
            'event_data'        => $content_options
        ];
        
        $results = HI_EVENTS_FUNCTIONS::events( $param );
    }
    
    $text_to_display =   $content_options['text_to_display'];
    $content_to_display = $content_options['event_content_to_display'];
    $max_word = $content_options['max_number_of_words'];

    $result_count = sizeof( $results['data'] );

    if(count($_REQUEST) > 0 || count($_REQUEST) == 0 ) : 
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
       [ 'page-element', 'listing-element', 'events-element', _get_field_value('display', $page_id),'grid', $grid_layout, _get_field_value('section_classes', $page_id), _get_field_value('theme', $page_id), _get_field_value('element_width', $page_id), _get_field_value('text_alignment', $page_id) ]
    );    
?>

<section <?php hi_set_pageid( _get_field_value('section_id', $page_id) ); ?> class="<?php echo $section_css; ?>">

    <div class="inner-section">
        <div class="grid-container">
            <div class="grid-x grid-padding-x section-body <?php echo $sf->getContentLoadType(); ?>" <?php echo _get_field_value('paging_type', $page_id) == "load_more" ? 'data-per-page="'.$posts_per_page.'"' : ''; ?> data-item-col="<?php echo $per_row; ?>">
                <?php 

                    if( $result_count > 0 ) : 
                        foreach( $results['data'] as $result ) :
                             $id = $result->ID;    
                                    $content = "";
                                    if( $text_to_display == 'excerpt' && has_excerpt( $id ) ){
                                        $content = wpautop( get_the_excerpt( $id ) );
                                    } else {
                                        $max_word = $text_to_display == 'description' && $max_word ? $max_word : 35;
                                         $content_post = get_post($id);
                                        $content = wpautop($content_post->post_content);
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = wp_trim_words( $content , $max_word);
                                    }
                            
                                    $hicBox = new hcPCBEvents();
                                    $past_event_class = ( $content_options['featured'] == 'past' ) ? 'event-has-ended' : '' ;
                                
                                    
                                    $hicBox->setClassesOf('hic-box-container', [ $per_row,$past_event_class ]);
                                    $hicBox->setTitle( get_the_title( $id ) );
                                    if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
                                        $terms = get_the_terms( $id , 'events_cat');
                                        if($terms && is_array($terms)) $hicBox->setTerms($terms);
                                    }
                                    if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicBox->setContent(  $content );
                                    $hicBox->setImage(new hcPCBLink( get_featured_image( $id ) ));
                                    
                                    if(isset($content_options['show_gallery']) ? $content_options['show_gallery'] : false ){
                                        if(isset($content_options['gallery_options']) ? $content_options['gallery_options'] : false){
                                            $new_options = array_merge($content_options['gallery_options'], array('thumb_center_mode' => false, 'thumb_to_show' => 5, 'thumb_arrows' => false, 'thumb_dots' => true) );
                                            $hicBox->setGalleryOptions($new_options);
                                        }
                                        $images = _get_field_value('proj_images' , $id);
                                        $video = _get_field_value('proj_video', $id);
                            
                                        if($images) $hicBox->setGalleryImages($images);
                                        if($video) $hicBox->setVideo2(new hcPCBLink($video['youtube_video']));
                                    }
                            
                            
                                    if( is_array($content_to_display) ? in_array('date_time', $content_to_display) : false ) {
                                       $hicBox->setDate(get_field('event_time' , $id ));
                                    }
                                    $hicBox->setPrice(get_field('price' , $id ));
                                    
                                    
                            
                                    $button = new hcPCBButtonElement();
                                    $button->constructButton(get_the_permalink($id), 'View Event');
                                    $hicBox->setButton($button);
                                    
                                     if(_get_field_value('post_featured')) {
                                        $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
                                    }
                            
                            $hicBox->displayContent();
                        endforeach; else: $sf->displayNoResult($no_result);  endif; 
                ?>
            </div>
            <?php 
                /*************************
                * PAGINATION
                *************************/
                /*
                if(_get_field_value('paging_type', $page_id) == 'pagination') $sf->displayPagination($posts_per_page,$result_count);
                elseif(_get_field_value('paging_type', $page_id) == 'load_more')
                if( $rel_query->have_posts() ) $sf->displayLoadmore();
                */
            
            ?>
            <?php if( $results['pager'] ) : ?>
                <div class="cell pager-column">
                    <div class="wp-pager">
                        <?php echo $results['pager']; ?>
                    </div>
                </div>    
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>