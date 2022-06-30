<?php

    
    $hs = new hicaliber_theme_helpers;

    $pcb = new hcContentBuilder(); 

    $woo_enabled = class_exists( 'WooCommerce' );

    $layout = $elements['pe_products_layout'];
    $design = $elements['pe_products_design'];
    
    $content_options = $elements['pe_products_content'];
    $text_to_display = $content_options['text_to_display'];
    $categories = $content_options['categories'];
    $content_to_display = $content_options['product_content_to_display'];
    $content_to_display_cat = $content_options['product_content_to_display_cat'];
    $max_word = isset($content_options['max_number_of_words']) ? $content_options['max_number_of_words'] : 25;

    $posts_per_page = $content_options['quantity'] ? $content_options['quantity'] : -1;
 
    $no_product = "<div class='column small-12 text-center'><h2>No Product Available. Please try other settings.</h2></div>";

    $content_type = $content_options['content_type'];

    $class = "";
    if( !(is_array($content_to_display) ? in_array('button', $content_to_display) : false) && $content_type == 'posts' ) {
        $class = "button-hidden";
    }
    if( !(is_array($content_to_display_cat) ? in_array('button', $content_to_display_cat) : false) && $content_type == 'categories' ) {
        $class = "button-hidden";
    }

    if($content_type == 'posts') {
        $listing_class = 'product-listing';
    } else {
        $listing_class = 'product-categories';
    }

     if($layout['slider_autoplay']) {        
        $set_data_autoplay = 'data-autoplay=1 data-autoplay-speed='.$layout['slider_speed'];    
    } else {
        $set_data_autoplay = '';
    }

    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'content-box-element', 'product-element', $listing_class, 'listing-element', $layout['display'], $design['section_classes'], $layout['layout_type'], ($layout['layout_type'] =='grid') ? $layout['grid_layout']: '', $design['theme'], $design['element_width'], $content_options['featured'] ? 'featured' : '', $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '', $class ]
    );

    $args = [
		'post_type' => 'product',
        'post_status' => 'publish',
        'per_page'  => $posts_per_page
    ];

    if( $content_options['featured'] == "select" ) {
        if( empty( $content_options['selected_product'] ) ) {
            $content_options['selected_product'] = [0];
        }
        $args['post__in'] = $content_options['selected_product'];
    } else {

        // * FEATURED POST
        if( $content_options['featured'] == "featured" ) {
            $args['meta_query'][] = [
                'key'       => 'post_featured',
                'value'     => 1,
                'compare' => '='
            ];
        }    


         // * IF PRODUCT ON SALE
         if( $content_options['on_sale'] && $content_type = 'posts' ) {
            if ( $woo_enabled ) {
                                                                        
                $date_s = current_time( 'mysql' );
                $date_unix = strtotime( $date_s );
 
                $args['meta_query'][] = [                                 
                    'type' => 'woo_sale_date'
                ];
                        
            } else {
                $args['meta_query'][] = [
                    'key' => 'prd_price_sale_price', 
                    'value' => "",                        
                    'compare' => '!='
                ];
            }
            

        }

        if($categories) {
            
            // print_r(  );
            $dc_category = $categories;
            if( sizeof( $categories ) == 1  && !empty( get_term_children( $categories[0] , 'product_cat' ) ) ) {
                $dc_category = get_term_children( $categories[0] , 'product_cat' );
            }
             
            $args['tax_query'] = [                        
                'taxonomy'  => 'product_cat',
                'field'     => 'term_id', 
                'terms'     => $dc_category,
                'operator' => 'IN'
            ];
        }

    }    
    
  

    $product_result = B_QUERY::qry( $args );  
    
    if($categories && is_array($categories)) {
        $terms = [];
        foreach($categories as $category){
            $term = get_term( $category, 'product_cat' );
            array_push($terms, $term);
        }
    } else {
        $terms =  get_terms( 'product_cat', array('hide_empty' => 0, 'parent' =>0) );
    }
    
    if( !empty( $product_result['data'] ) || ( !empty($terms) && $content_type == 'categories' ) ) :

    ?>

    <section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>" data-content-products>

       <?php echo $hs::design_background_image( $design['background_image'] ); ?>
       <div class="inner-section">
        <div class="grid-container">            
        <?php $pcb->printHeader($elements['pe_products_header']); ?>                    
        <div class="grid-x grid-padding-x section-body product-list" data-item-col="<?php echo $layout['per_row']; ?>" <?php echo $set_data_autoplay; ?>>                
            <?php 
                if($content_type == 'categories') :                     
                    
                    
                
                    if( is_array($terms) ? count($terms) > 0 : false ) : $current_count = 0; foreach( $terms as $term ) :                        
                        $flag = true;
                        // if selected product category is featured
                        if( $content_options['featured'] == "featured" ) {
                            $flag = false;
                            $product_featured = $term->taxonomy . '_' . $term->term_id;                                                        
                            if( get_field( 'prod_cat_featured', $product_featured ) == 1 ) {
                                $flag = true;
                            }                            
                        }
                        if( $flag ) :
                            $description = $term->description;
                            if(!$description) {
                                $description = wp_trim_words( get_field('pc_content', $term) , 20 );
                            }

                            $hicBox = new hcPCBProduct();
                            $hicBox->setTitle( $term->name );

                            if( in_array('description', $content_to_display_cat) ) $hicBox->setContent( $description ); 
                            $hicBox->setImage(new hcPCBLink( get_field( 'pc_featured_image', $term ) ));

                            $button = new hcPCBButtonElement();
                            $button->constructButton(get_category_link($term->term_id), "View <span>Products</span>" );
                            $hicBox->setButton($button);
                            
                            $hicBox->setClassesOf('hic-box-container', [ $layout['per_row'] ]);                       
                            $hicBox->displayContent();

                            $current_count ++;
                            if($posts_per_page && $current_count == $posts_per_page) break;
                        endif;
                        
                    endforeach; else: echo $no_product;  endif;
                else :                                         
                                                    
                    if( !empty( $product_result ) ) : foreach(  $product_result['data'] as $product ) :
                                            
                        $the_id = $product;
                        $the_the_title = get_the_title( $the_id );
                        $onsale = "";
                        
                        $content = "";
                        if( $text_to_display == 'excerpt' && has_excerpt( $the_id ) ){
                            $content = wpautop( get_the_excerpt( $the_id ) );
                        } else {
                            $max_word = $text_to_display == 'description' && $max_word ? $max_word : 20;
                            $content = force_balance_tags_trim_words( get_the_content( null, false, $the_id ), $max_word );
                        }
                        
                        $hicBox = new hcPCBProduct();
                        $hicBox->setTitle( $the_the_title );
                        
                        if( in_array('category', $content_to_display) ) {
                            $terms = get_the_terms( $the_id , 'product_cat');
                            if( !empty( $terms ) ) {
                                $hicBox->setTerms($terms);
                            }                            
                        }

                        if( in_array('description', $content_to_display) ) $hicBox->setContent( $content );
                        $hicBox->setImage(new hcPCBLink( get_featured_image(  $the_id  ) ));
                        $hicBox->setSecondaryImage(new hcPCBLink( get_field( 'post_featured_image_2',  $the_id  ) ));
                        $button = new hcPCBButtonElement();
                        $button->constructButton(get_the_permalink( $the_id ), "View <span>Product</span>" );
                        $hicBox->setButton($button);
                        // Add Add_to_Cart button if woocommerce is active
                        
                        $pv = new PRODUCT_VIEW();
                        
                                                                        
                        $a2cbtn="";
                        $a2wlbtn="";

                        if(PRODUCT_HELPER::is_fav_icon_visible()){
                            $product_price_details = get_field('prd_price', $the_id);
                            $prd_dimensions_details = get_field('prd_size_box_details', $the_id);
                            
                            if(  $woo_enabled ){
                                $product = wc_get_product( $the_id );
    
                                $pv->init($product);
                            }
                            $prod_details = $pv::set_product_details(
                                $pv->woo_products, 
                                $product_price_details, 
                                $prd_dimensions_details
                            );
        
                            $a2wlbtn = $pv::get_add2wishlist($the_id, $prod_details);
                        }

                        if(  $woo_enabled ){
                            $product = wc_get_product( $the_id );

                            $pv->init($product);
                            
                            $onsale = $product->is_on_sale() ? "on-sale" : "";
                            $hicBox->setProductID(  $the_id  );
                            $hicBox->isWooProduct =  $woo_enabled;
                            $action_buttons = get_field('prd_actions_main' , $the_id);
                            $prd_featured_product = get_field('prd_featured_product', $the_id);
                            $prod_details = $pv::set_product_details($pv->woo_products, get_field('prd_price' , $the_id), get_field('prd_size_box_details', $the_id));
                            $a2cbtn = new hcPCBButtonElement();
                            $a2cbtn = $pv::get_add2cart( $action_buttons, $prd_featured_product, $prod_details, "", "", "", $the_id  );
                            
                            if( in_array('price',$content_to_display) ){
                                
                                $hicBox->setPriceUnit($pv->price_unit);
                                $hicBox->setProductType($pv->product_type);
                                
                                
                                if($pv->product_type=="simple") {
                                    if( is_array($prod_details) && isset($prod_details['price_details']) ){                                        
                                        if(is_array($prod_details['price_details'])){
                                            extract($prod_details['price_details']);
                                            $hicBox->setPrice($rrp);
                                            $hicBox->setPriceHtml( $price_html );
                                            $hicBox->setSalePrice($our_price);
                                            $hicBox->priceIsHot($our_price_to_hot_to_list);
                                        } 
                                    }
                                } elseif( $pv->product_type=="variable" ) {    
                                    
                                    $var_sale_price     =  $product->get_variation_sale_price( 'min', true );
                                    $var_regular_price  =  $product->get_variation_regular_price( 'min', true );
                                    
                                    $var_price = $var_regular_price;

                                    if( $var_sale_price ) {
                                        $var_price = $var_sale_price;
                                    }
                                    
                                    if( isset( $prod_details['price_details'] ) ) {                                        
                                        foreach( $prod_details['price_details'] as $prod_detail) {
                                            extract($prod_detail);
                                            $hicBox->setPrice( $var_price );                                            
                                            $hicBox->setSalePrice( $var_price );
                                            $hicBox->setPriceHtml( $price_html );
                                            // $hicBox->priceIsHot($our_price_to_hot_to_list);
                                            break;
                                        }
                                    }
                                    
                                }

                                
                            }
                        } else {
                            $price =  get_field( 'prd_price' , $the_id ) ;                                                        
                            $onsale = !empty( $price['sale_price'] ) ? "on-sale" : "";                        
                            $hicBox->setPrice( $price['rrp'] );
                            $hicBox->setSalePrice( $price['sale_price'] );                                                       
                        }

                        if($a2wlbtn) $hicBox->setAdd2Wishlist($a2wlbtn);
                        if($a2cbtn) $hicBox->setAdd2Cart($a2cbtn);
                        // ----------------

                        
                        
                        $hicBox->setClassesOf('hic-box-container', [ $onsale, $layout['per_row'] ]);
                        $hicBox->displayContent();
                        
                    endforeach; else: echo $no_product;  endif; wp_reset_postdata(); 
                endif; ?>
            </div>   
                
            <?php $pcb->printFooter($elements['pe_products_footer']); ?>
        
        </div>
        </div>
    </section>
<?php endif; ?>    