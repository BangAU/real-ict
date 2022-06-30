<?php

    $hs = new hicaliber_theme_helpers;
    
    $post_type = get_field('post_type');
    
    $posts_per_page = get_field('op_property_to_show') ? get_field('op_property_to_show') : 9;
    
    $per_row = get_field('per_row');

    $woo_enabled = class_exists( 'WooCommerce' );

    
    $search_form_title = get_field('property_search_form_title');
    $search_form_placeholder = get_field('search_filter_placeholder');
    $show_search_bar = get_field('show_property_search_form');
    $content_to_display = get_field('product_content_to_display');
    $text_to_display = get_field('text_to_display');
    $max_word = get_field('max_number_of_words');
    $no_result = get_field('no_search_results');
    
    $show_pap_sidebar = false;
	$show_product_sidebar = get_field('show_product_sidebar','options');
	$sidebar_location = get_field('product_sidebar_location','options');
	if( is_array($sidebar_location) ) extract( $sidebar_location );	
	$product_sidebar = $show_product_sidebar && $show_pap_sidebar;

    $ar = [
		'post_type' => 'product',
        'post_status' => 'publish',
        'per_page'  => $posts_per_page
    ];
    
    
    $categories = get_field('products_categories');

    if( !empty( $_REQUEST['tags']  ) || !empty( $_REQUEST['product_name']  ) ) {
		$woo_atts =  B_QUERY::woo_product_atts();
		foreach( $_REQUEST as $key => $request ) {
			$e = false;
			
			if( $request != NULL  || !empty( $request ) ) { 
				$request = sanitize_text_field( $request );

				if( $key == 'product_name' ) {
                    $keywords = explode(" ",$request);
				    $or_conditions = array();
				    $or_statement = "";
				    // echo '<div style="display: none;">';var_dump(is_array($keywords)); echo '</div>';
				    if(is_array($keywords)) foreach($keywords as $key){
				        $or_conditions[] = "posts.post_title LIKE '%%{$key}%%'";
				    }
				    if(count($or_conditions) > 0){
				        $or_statement = implode(" AND ", $or_conditions);
				    }
				    
				    if($or_statement){
				        // 	$ar['where'][] = "AND posts.post_title LIKE '%%{$request}%%'";
				        $ar['where'][] = "AND ({$or_statement})";
                    }
                }
                if( $key == 'tags' ) {
					if( B_QUERY::woo_tax_qry( $key , $request , 'product_tag' ) ){
						$e = B_QUERY::woo_tax_qry( $key , $request , 'product_tag' );
						$ar['join'][] = $e['join'];
						$ar['where'][] = $e['where'];
					}
				}
				if( $woo_atts ) {
					if( in_array( $key , $woo_atts ) ) {
						if( B_QUERY::woo_tax_qry( $key , $request , "pa_".$key ) ){
							$e = B_QUERY::woo_tax_qry( $key , $request , "pa_".$key );
							$ar['join'][] = $e['join'];
							$ar['where'][] = $e['where'];
						}
					}
				}
			}
		}
	} else {
	    
	     if( !empty( $categories ) ) {
            
            $dc_category = $categories;
            if( sizeof( $categories ) == 1  && !empty( get_term_children( $categories[0] , 'product_cat' ) ) ) {
                $dc_category = get_term_children( $categories[0] , 'product_cat' );
            }
             
            $ar['tax_query'] = [                        
                'taxonomy'  => 'product_cat',
                'field'     => 'term_id', 
                'terms'     => $dc_category,
                'operator' => 'IN'
            ];
        }
        
	}
	
    
    
	$d = B_QUERY::qry( $ar );
    /*************************
     * SEARCH RESULTS
     *************************/
    $class = "";
    if( !(is_array($content_to_display) ? in_array('button', $content_to_display) : false) ) {
        $class = "button-hidden";
    }
    $section_css = "";
    $section_css = $hs::css_class_helper(
       [ 'page-element', 'product-element', 'product-listing', 'listing-element', 'content-box-element', 'grid', get_field('display'), get_field('section_classes'), get_field('theme'), get_field('element_width'), get_field('text_alignment'), $class ]
    );
?>

<section data-cpt-archive-product <?php hi_set_pageid( get_field('section_id') ); ?> class="<?php echo $section_css; ?>">

    <div class="inner-section">
        
        <div class="grid-container">

            <div class="grid-x grid-padding-x section-body product-list" data-item-col="<?php echo $per_row; ?>">
                
          
            <?php
            if( isset( $d['data'] ) ) {

                $prod_details = array();

                
              foreach( $d['data'] as $v ) {
                $extra_class = "";
                $property_class="";
                $content = "";
                $onsale = "";
                if( $text_to_display == 'excerpt' && has_excerpt($v) ){
                    $content = wpautop( get_the_excerpt($v) );
                } else {
                    $max_word = $text_to_display == 'description' && $max_word ? $max_word : 20;
                    $content = force_balance_tags_trim_words( get_the_content(null, false, $v), $max_word, false );
                } 
                  $hicBox = new hcPCBProduct();

                 
                  $hicBox->setProductID($v);
                  $hicBox->setTitle( get_the_title( $v ) );
                  if( is_array($content_to_display) ? in_array('description', $content_to_display) : false ) $hicBox->setContent( $content );
                  if( is_array($content_to_display) ? in_array('category', $content_to_display) : false ) {
                      $terms = get_the_terms( $v, 'product_cat');
                      
                      if($terms) {
                          $hicBox->setTerms($terms);
                      }
                      
                  }
                  $hicBox->setImage(new hcPCBLink( get_featured_image( $v ) ));
                  $hicBox->setSecondaryImage(new hcPCBLink( get_field( 'post_featured_image_2', $v ) ));
                  $button = new hcPCBButtonElement();
                  $button->constructButton(get_the_permalink( $v ), "View <span>Product</span>" );
                  $hicBox->setButton($button);
                  $pv = new PRODUCT_VIEW();

                  $woo_products = $pv->woo_products;
                  $pv->init($pv::check_woocommerce_active_status() ? wc_get_product( $v ) : false);
                  $a2cbtn="";
                  $a2wlbtn="";
                  
                  if(PRODUCT_HELPER::is_fav_icon_visible()){
                    $product_price_details = get_field('prd_price', $v);
                    $prd_dimensions_details = get_field('prd_size_box_details', $v);

                    $prod_details = $pv::set_product_details(
                        $pv->woo_products, 
                        $product_price_details, 
                        $prd_dimensions_details
                    );

                    $a2wlbtn = $pv::get_add2wishlist($v, $prod_details);
                  }
                 
                  if( $woo_enabled ){
                    $action_buttons = get_field('prd_actions_main' , $v );
                    $prd_featured_product = get_field('prd_featured_product', $v);
                    $hicBox->isWooProduct =  $woo_enabled;

                    if($pv->product_type == 'simple'){
                        $prod_details = $pv::set_product_details( 
                            $pv->woo_products, 
                            get_field('prd_price' , $v), 
                            get_field('prd_size_box_details', $v )
                        );
                    } elseif($pv->product_type == 'variable') {
                        $vpv = new PRODUCT_VIEW();
                        $vpv->init($pv::check_woocommerce_active_status() ? new WC_PRODUCT( $v ) : false);
                        $prod_details = $pv::set_product_details( 
                            $vpv->woo_products, 
                            get_field('prd_price' , $v), 
                            get_field('prd_size_box_details', $v )
                        );
                    }
                    $a2cbtn = new hcPCBButtonElement();
                    $a2cbtn = $pv::get_add2cart( $action_buttons, $prd_featured_product, $prod_details, "","","", $v );                    

                    if( is_array($content_to_display) ? in_array('price',$content_to_display) : false ) {
                        
                        $hicBox->setPriceUnit($pv->price_unit);
                        $hicBox->setProductType($pv->product_type);
                    
                            if( is_array($prod_details) && isset($prod_details['price_details']) ){
                             
                                if(is_array($prod_details['price_details'])){
                                    extract($prod_details['price_details']);
                                    if( ( $our_price || $our_price_to_hot_to_list ) ){
                                        $extra_class = "on-sale";
                                    }
                                    $hicBox->setPrice($rrp);
                                    $hicBox->setPriceHtml( $price_html );
                                    $hicBox->setSalePrice($our_price);
                                    $hicBox->priceIsHot($our_price_to_hot_to_list);
                                } 
                            }
                        
                    }
                } else {
                    $price =  get_field( 'prd_price' , $v ) ;                                                        
                    $extra_class = !empty( $price['sale_price'] ) ? "on-sale" : "";                        
                    $hicBox->setPrice( $price['rrp'] );
                    $hicBox->setSalePrice( $price['sale_price'] );
                }
                if($a2wlbtn) $hicBox->setAdd2Wishlist($a2wlbtn);
                if($a2cbtn) $hicBox->setAdd2Cart($a2cbtn);
                $hicBox->setClassesOf('hic-box-container', [ $per_row , $extra_class , (in_array('stock_status',$prod_details)) ? $prod_details['stock_status'] : '' ]);
                $hicBox->displayContent();
                
              } 
              if( isset( $d['pager'] ) ) {
                echo "<div class='cell pager-column'><div class='wp-pager'>".$d['pager']."</div></div>";
              }              
            } else {
                  echo $no_result;
              }

            ?>
              </div>
       </div>   
       
    </div>
</section>