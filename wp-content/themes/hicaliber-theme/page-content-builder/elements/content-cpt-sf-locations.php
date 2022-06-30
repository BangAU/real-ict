<?php

    $page_id = get_the_ID();
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder();

    $is_public = _get_field_value('ls_single_page', 'options');
    
    $post_type = get_field('post_type');
    
    $posts_per_page = get_field('op_property_to_show') ? get_field('op_property_to_show') : 9;
    $per_row = get_field('per_row');
    
    $grid_layout = get_field('cpt_grid_layout');
    $display = get_field('display');

    $section_class = get_field('section_classes');
    $theme = get_field('theme');
    $width = get_field('element_width');
    $alignment = get_field('text_alignment');
    
    $cpt_header = get_field('cpt_content_header');
    
    $search_form_title = get_field('property_search_form_title');
    $search_form_placeholder = get_field('search_filter_placeholder');
    $show_search_bar = get_field('show_property_search_form');
    $content_to_display = get_field('locations_content_to_display');
    $text_to_display = get_field('text_to_display');
    $max_word = get_field('max_number_of_words');
    $no_result = get_field('no_search_results');

    $tag_filter = _get_field_value('cpt_show_tag_filter' , $page_id);
    $state_filter = get_field('cpt_show_state_filter');
    $state_filter_placeholder = get_field('cpt_state_filter_placeholder');
    
    $cpt_archive_order_by = _get_field_value('cpt_archive_order_by' , $page_id);
    $cpt_archive_order = _get_field_value('cpt_archive_order' , $page_id);
    
    $show_pap_sidebar = false;
    // $show_product_sidebar = get_field('show_product_sidebar','options');
    // $sidebar_location = get_field('product_sidebar_location','options');
    // if( is_array($sidebar_location) ) extract( $sidebar_location ); 
    // $product_sidebar = $show_product_sidebar && $show_pap_sidebar;

    /*************************
     * Search Filter
     *************************/
    $show_form = _get_field_value('show_search_form', $page_id);
    
    
    $location_cat_slug  = "location_cat" ;
    $cpt_category  = "location_cat" ;
    
    
    $selected_cat_posts = _get_field_value($post_type . '_categories', $page_id);
   
    $selected_categories = isset($_REQUEST[ $location_cat_slug ]) ? $_REQUEST[ $location_cat_slug ] : 'any';
    
    $selected_sub_categories = isset($_REQUEST[ 'sub_' . $location_cat_slug ]) ? $_REQUEST[  'sub_' .  $location_cat_slug ] : 'any';
    
    $post_name_search = isset( $_GET['events_search_field'] ) ? $_GET['events_search_field'] : "";
    $sf = new hcPCBSearchFilter($search_form_title, $post_type, $cpt_category, $selected_cat_posts);    
    
    
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
        
            
            $sf->setFilterOptions( $location_cat_slug , $catOptions, $cat_filter_placeholder);
          
            $sf->setFilterProperties( $location_cat_slug, [
                    'name'      => $location_cat_slug,
                    'selected'  => $selected_categories
                ]);            
        endif;
        
        if(_get_field_value('show_sub_category_filter', $page_id)) :
            
            $sub_cat_filter_placeholder = _get_field_value('sub_category_filter_placeholder', $page_id);
            
            // Set Sub Category Filter Options
            // Set Sub Category Filter Options
            $subCatOptions = $sf->getSubCatOptionsBy($cpt_category);
        
            if(count($subCatOptions) > 0){
                $sf->setFilterOptions( 'sub_' . $location_cat_slug , $subCatOptions, $sub_cat_filter_placeholder);
          
                $sf->setFilterProperties( 'sub_' . $location_cat_slug, [
                        'name'      => 'sub_' . $location_cat_slug,
                        'selected'  => isset($_REQUEST[ 'sub_' . $location_cat_slug ]) ? $_REQUEST[ 'sub_' . $location_cat_slug ] : '',
                    ]);  
            }        
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
        
        if( $tag_filter ) {
            
            $tag_name = "tag_name";
            $tag_option = $sf->getCatOptionsBy('location_tag');
           
            $tag_filter_placeholder = _get_field_value('cpt_tag_filter_placeholder', $page_id);
            
            $sf->setFilterOptions( $tag_name , $tag_option, $tag_filter_placeholder);
            
            $sf->setFilterProperties( $tag_name, [
                    'name'      =>  $tag_name,
                    'selected'  => isset($_REQUEST[  $tag_name ]) ? $_REQUEST[ $tag_name] : '',
            ]);            
            
        }
        
        $company_field = "member_location";
        
        
        $location_option = [];       
        
        if( class_exists('HI_THEME') ) {
            $states = HI_THEME::au_states();
            foreach( $states as $key => $val ) {
                $location_option[] = [
                    'val'   => $key,
                    'name'  => $val
                ];
            }
        }
        
       if($state_filter) : 
           
           $sf->setFilterOptions( $company_field, $location_option, $state_filter_placeholder);
            
           $sf->setFilterProperties( $company_field , [
                'name'      => $company_field,
                'selected'  => isset($_REQUEST[ $company_field ]) ? $_REQUEST[$company_field] : '',
            ]);
        
        endif;
        
        
        
        if( get_field('show_alphabetical_filter') ) {
            $order_options = [   
                [
                    'val'   => "a-z",
                    'name'  => "A-Z",
                ],
                
                [
                    'val'   => "z-a",
                    'name'  => "Z-A",
                ]    
            ];
            
            $order_field = 'order';
            $order_type = get_field('alphabetical_filter_placeholder') ? get_field('alphabetical_filter_placeholder') :  "Order By";
            
            $sf->setFilterOptions( $order_field, $order_options, $order_type);
                
            $sf->setFilterProperties( $order_field , [
                'name'      => $order_field,
                'selected'  => isset($_REQUEST[ $order_field ]) ? $_REQUEST[$order_field] : '',
            ]);
        
        }
    
    endif;
    
    $ar = [
        'post_type' => 'location',
        'post_status' => 'publish',
        'per_page'  => $posts_per_page
    ];
    
    
    $categories = get_field('locations_categories');

    if( isset( $_REQUEST ) ) {
        $parent_child_category = false;
        if( !empty( $_REQUEST['location_cat'] ) && !empty( $_REQUEST['sub_location_cat'] )  ) {
            if( $_REQUEST['location_cat'] != "any" &&  $_REQUEST['sub_location_cat'] != "any"   ) {
                $parent_child_category = true;    
            }
            
        }
        
        foreach( $_REQUEST as $key => $request ) {
            $e = false;
            $request = sanitize_text_field( $request );
            if( $request != NULL  || !empty( $request ) ) { 
                if( $key == 'locations_search_field' ) {
                    
                    if( preg_match('(^[0-9]{4}$)',$request) ) {
                        $ar['meta_query'][] = [
                            'key'       => 'location_address_postcode',
                            'value'     => $request,
                            'compare'   => 'LIKE'
                        ];
                    } else {
                        $ar['where'][] = "AND posts.post_title LIKE '%%{$request}%%'";
                    }
                }         
                
                if( $key == 'member_location' && $request != "any" ) {
                    $ar['meta_query'][] = [
                            'key'       => 'location_address_state',
                            'value'     => $request,
                            'compare'   => 'LIKE'
                        ];
                }
                
                
                if( $parent_child_category ) {
                    
                    if( $key == 'sub_location_cat'  && $request != "any" ) {
                         $category = get_term_by('slug', $request, 'location_cat');
                         if( !empty( $category )   && $request != "any" ) {
                            $ar['tax_query'][] = [                        
                                'taxonomy'  => 'location_cat',
                                'field'     => 'term_id', 
                                'terms'     => $category->term_id,
                                'operator' => 'LIKE'
                            ]; 
                         }
                    }
                    
                } else {
                    
                    if( ( $key == 'location_cat' || $key == 'sub_location_cat' )  && $request != "any" ) {
                         
                         $category = get_term_by('slug', $request, 'location_cat');
                         $operator = "LIKE";
                         $value_terms =  $category->term_id;
                         
                         if( $key == 'location_cat' ) {
                                
                            $sub_terms = get_term_children( $category->term_id , 'location_cat' );
                            
                            if( is_array( $sub_terms )  ) {
                                if( sizeof( $sub_terms ) > 0 ) {
                                    $value_terms =  $sub_terms;
                                    $operator = "IN";
                                }
                            }
                             
                         }
                         
                         if( !empty( $category )   && $request != "any" ) {
                            $ar['tax_query'][] = [                        
                                'taxonomy'  => 'location_cat',
                                'field'     => 'term_id', 
                                'terms'     => $value_terms,
                                'operator' => $operator
                            ]; 
                         }
                    }
                    
                }
                
                if( $key == 'order'  && $request != "any" ) {
                    $order_key = $request == 'a-z'? 'ASC' : 'DESC';
                     $ar['order'] = " ORDER BY posts.post_title {$order_key}";
                }
                
                if( $key == 'tag_name'  && $request != "any" ) {
                     $tag_name = get_term_by('slug', $request, 'location_tag');
                     if( !empty( $tag_name ) ) {
                        $ar['tax_query'][] = [                        
                            'taxonomy'  => 'location_tag',
                            'field'     => 'term_id', 
                            'terms'     => $tag_name->term_id,
                            'operator' => 'LIKE'
                        ]; 
                     }
                   
                }
                
            }
        } 
    }
    
    
    $d = L_QUERY::qry( $ar );
    /*************************
     * SEARCH RESULTS
     *************************/
    $class = "";
    if( !(is_array($content_to_display) ? in_array('button', $content_to_display) : false) ) {
        $class = "button-hidden";
    }
    $section_css = "";
    $section_css = $hs::css_class_helper(
       [ 'page-element', 'location-element', 'content-box-element', 'grid', $grid_layout, $display, $section_class, $theme, $width, $alignment, $class ]
    );
?>


<section <?php hi_set_pageid( get_field('section_id') ); ?> class="<?php echo $section_css; ?>">

    <div class="inner-section">
        
            <div class="grid-container">
                <?php $pcb->printHeader($cpt_header); ?>
                    <div class="grid-x grid-padding-x section-search-form">
                <?php 
                   $sf->displaySearchFilterV2($show_search_bar, $search_form_title, $search_form_placeholder);
                ?>
            </div>
            
            <div id="locationMain" class="grid-x grid-padding-x section-body" data-item-col="<?php echo $per_row; ?>">
                

            <?php
            if( isset( $d['data'] ) ) {

                $prod_details = array();

                
              foreach( $d['data'] as $v ) {
                $extra_class = "";
                $property_class="";
                $content = "";
                if( $text_to_display == 'excerpt' && has_excerpt($v) ){
                    $content = wpautop( get_the_excerpt($v) );
                } else {
                    $max_word = $text_to_display == 'description' && $max_word ? $max_word : 20;
                    $content = force_balance_tags_trim_words( get_the_content(null, false, $v), $max_word, false );
                } 
                  $hicBox = new hcPCBLocation();
                  
                    $hicBox->setTitle( get_the_title( $v ) );            
            
                    $location_terms = get_the_terms( $v , 'location_cat');
                    $los = [];
                    
                    if( $location_terms ) {
                        foreach( $location_terms as $term ) {
                            $los[] = $term->slug;
                        }
                    }
                    
                    $los = implode(" ", $los );
            
                    $hicBox->setClassesOf('hic-box-container', [ $per_row , 'location-item' , $los ]);
                    
                    if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
                        $terms = get_the_terms( $v, 'location_cat');
                        if($terms && is_array($terms)) $hicBox->setTerms($terms);
                    }
                    if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicBox->setContent(  $content );
                    
                    $featured_image = get_featured_image( $v  );
                                  
                    $hicBox->setImage(new hcPCBLink( $featured_image ));
                    
                    if(isset($content_options['show_gallery']) ? $content_options['show_gallery'] : false ){
                        if(isset($content_options['gallery_options']) ? $content_options['gallery_options'] : false){
                            $new_options = array_merge($content_options['gallery_options'], array('thumb_center_mode' => false, 'thumb_to_show' => 5, 'thumb_arrows' => false, 'thumb_dots' => true) );
                            $hicBox->setGalleryOptions($new_options);
                        }
                        $images = _get_field_value('gallery', $v );
            
                        if($images) $hicBox->setGalleryImages($images);
                        if($video) $hicBox->setVideo2(new hcPCBLink($video['youtube_video']));
                    }
                    
                    if( is_array($content_to_display) ? in_array('contact', $content_to_display) : false ) {
                        $hicBox->setLocation(get_field('location_address', $v ));
                        $hicBox->setEmail(get_field('location_email_address', $v ));
                        $hicBox->setPhone(get_field('location_phone',$v));
                        $hicBox->setWebsite(get_field('location_website',$v));
                    }                    
                    //Contact Details

        
                    
                    //Checking if Single Post is enable, Button will not display if Single Post is disabled
                    
                    $button_label = 'View';
                    
                    if($is_public) {
                        $button = new hcPCBButtonElement();
                        $button->constructButton(get_the_permalink($v), $button_label );
                        $hicBox->setButton($button); 
                    }
                    $hicBox->setIsPublic($is_public);
                    
                    if(_get_field_value('post_featured')) {
                        $hicBox->setClassesOf('hic-box', [ 'is-featured' ]);
                    }
                    
                    
                  $hicBox->displayContent();  
                } 
               
                
                 if( isset( $d['pager'] ) ) {
                    echo "<div class='cell pager-column'><div class='wp-pager'>".$d['pager']."</div></div>";
                  }  
                          
            } else {
                    echo "<div class='cell'>{$no_result}</div>";
              }
              
              

            ?>
              </div>
       </div>   
       
    </div>
</section>