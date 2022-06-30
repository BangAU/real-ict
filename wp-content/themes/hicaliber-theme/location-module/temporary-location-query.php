<?php
class L_QUERY {

public static function meta_query( $meta = [], $wp ) {

    $wheres = [];
    $joins = [];

    if( is_array( $meta ) ){            
        foreach( $meta as $m ) {
            
            if( !empty( $m['type'] ) ) {

                if( $m['type'] == 'flag' ) { 
                    $joins[] = self::join( 'LEFT', 'property_hide' , 'hide_on_website' );
                    $wheres[] = "AND (property_hide.meta_value IS NULL OR property_hide.meta_value = 0 )"; 
                }
                
                if( $m['type'] == 'woo_sale_date'  ) {

                        $sale_price = '_sale_price';
                        $from = '_sale_price_dates_from';
                        $to = '_sale_price_dates_to';

                        $sale_value_value = $sale_price.".meta_value";
                        $from_mata_value = $from.".meta_value";
                        $to_mata_value = $to.".meta_value";

                        $date_format = "UNIX_TIMESTAMP()";

                        
                        $joins[] = "INNER JOIN {$wp->prefix}postmeta AS {$sale_price} ON {$sale_price}.post_id = posts.ID AND {$sale_price}.meta_key = '{$sale_price}'";
                        $joins[] = "LEFT JOIN {$wp->prefix}postmeta AS {$from} ON {$from}.post_id = posts.ID AND {$from}.meta_key = '{$from}'";
                        $joins[] = "LEFT JOIN {$wp->prefix}postmeta AS {$to} ON {$to}.post_id = posts.ID AND {$to}.meta_key = '{$to}'";

                        
                        $condition_1 = "( $sale_value_value != '' AND $from_mata_value IS NULL AND $to_mata_value IS NULL )";
                        $condition_2 = "( {$from_mata_value} <= {$date_format} AND {$to_mata_value} IS NULL )";
                        $condition_3 = "( {$to_mata_value} >= $date_format AND $from_mata_value IS NULL )";
                        $condition_4 = "( {$to_mata_value} >= $date_format AND {$from_mata_value} <= {$date_format} )";

                        $wheres[] = "AND ( $condition_1 OR $condition_2 OR $condition_3 OR $condition_4)";

                        /*
                        AND ( 
                            ( _sale_price.meta_value != '' AND _sale_price_dates_from.meta_value IS NULL AND _sale_price_dates_to.meta_value IS NULL ) OR
                            ( _sale_price_dates_from.meta_value <= UNIX_TIMESTAMP() AND _sale_price_dates_to.meta_value >= UNIX_TIMESTAMP() ) OR 
                            ( _sale_price_dates_from.meta_value <= UNIX_TIMESTAMP() AND _sale_price_dates_to.meta_value IS NULL ) OR 
                            ( _sale_price_dates_to.meta_value >= UNIX_TIMESTAMP() AND _sale_price_dates_from.meta_value IS NULL ) 
                            ) ORDER BY posts.post_date DESC                      
                        */

                }
               
                // DATE META QUERY
                if( $m['type'] == 'date' ) {                                       
                    if( $m['compare'] == 'current' ) {

                        $start_date = $m['start_date'];
                        $end_date = $m['end_date'];

                        $start_date_mata_value = $start_date.".meta_value";
                        $end_date_mata_value = $end_date.".meta_value";

                        $joins[] = "INNER JOIN {$wp->prefix}postmeta AS {$start_date} ON {$start_date}.post_id = posts.ID AND {$start_date}.meta_key = '{$start_date}'";
                        $joins[] = "LEFT JOIN {$wp->prefix}postmeta AS {$end_date} ON {$end_date}.post_id = posts.ID AND {$end_date}.meta_key = '{$end_date}'";

                        $wheres[] = "AND ( ( DATE_FORMAT({$start_date_mata_value}, '%%Y-%%m-%%d 00:00:00') <= NOW() AND $end_date_mata_value = '' ) OR DATE_FORMAT($end_date_mata_value, '%%Y-%%m-%%d 23:59:59') >= NOW() )";
                    }
                }
                //--- DATE META QUERY
                
            } else {
                $default_join = !empty( $m['join'] ) ? $m['join'] : "INNER";      
                $joins[] = "{$default_join} JOIN $wp->postmeta AS {$m['key']} ON {$m['key']}.post_id = posts.ID AND {$m['key']}.meta_key = '{$m['key']}'";
                if( !empty( $m['compare'] ) ) {
                    $wheres[] = "AND {$m['key']}.meta_value {$m['compare']} '{$m['value']}'";
                }                
            }

        }

    }

    $joins = implode( " ", $joins  );
    $wheres = implode( " ", $wheres  );

    return $query_result = [
        'joins'  => $joins,
        'wheres' => $wheres
    ];
    
}


public static function tax( $tax, $wpdb ) {
    
    $joins = [];  
    $wheres = [];

    foreach( $tax as $t ) {
        $category = $t['taxonomy'];
        $field = $t['field'];
        $operator = $t['operator'];
        $scl = $t['terms'];
        
        
        if(  !empty( $scl ) && $operator == "IN"  ) {
            $scl  = implode(",",$scl);
        }
        
        $as_rel = "rel_".$category;
        $as_tax = "tax_".$category;
        $as_term = "term_".$category;
        
        $joins[] = "INNER JOIN $wpdb->term_relationships AS {$as_rel} ON (posts.ID = {$as_rel}.object_id)";
        $joins[] = "INNER JOIN $wpdb->term_taxonomy AS {$as_tax} ON ({$as_rel}.term_taxonomy_id = {$as_tax}.term_taxonomy_id AND {$as_tax}.taxonomy='{$category}')";
        $joins[] = "INNER JOIN $wpdb->terms AS $as_term ON ({$as_term}.{$field} = {$as_tax}.{$field} )";
        if( $operator == "IN" ) {
            $wheres[] = "AND $as_term.{$field} {$operator} ({$scl})";
        } else {
            $wheres[] = "AND $as_term.{$field} {$operator} '{$scl}'";
        }
    }

    
    

    $joins = implode( " ", $joins  );
    $wheres = implode( " ", $wheres  );

    return $query_result = [
        'joins'  => $joins,
        'wheres' => $wheres
    ];
        
   
    
}
    

public static function qry( $args = [] ){
    global $wpdb;
    
    $limit = "";
    $list=[];
    $per_page = 0;
    $sql = "";
    $joins = "";
    $wheres = "";
    $prepare_args = ['publish'];
    $paginate = true;
    
    $pre_qry_join = [];
    $pre_qry_where = ['1=1'];

    $order = "ORDER BY posts.post_date DESC";

    if( !empty( $args['order'] ) ) {
        $order = $args['order'];
    }

    if( !isset($args['per_page']) ) {
        $args['per_page'] = 9;
    }

    $current_page = max(1, get_query_var('cpage') );

    $per_page = $args['per_page'];

    $args['where'][] = "AND posts.post_type = '{$args['post_type']}'";
    
    if( isset( $args['post_status'] ) ) {
        $pre_qry_where[] = "AND posts.post_status = %s";
        $prepare_args = [ $args['post_status'] ];
    } else {
        $prepare_args = ['publish'];
    }

    // NOT IN
    if( isset( $args['post_not_in'] ) ) {
        $id_temp = implode(",", $args['post_not_in']) ;
        $args['where'][] = "AND posts.ID NOT IN ({$id_temp})";
    }

    // IN
    if( isset( $args['post__in'] ) ) {
        $id_temp = implode(",", $args['post__in']) ;
        $args['where'][] = "AND posts.ID IN ({$id_temp})";
    }    

    foreach( $args as $key => $arg ){
        # META QUERY
        if( $key == 'meta_query' ){                
            $meta_query = self::meta_query( $arg, $wpdb );
        }

        if( $key == 'tax_query' ){                
            $tax_query = self::tax( $arg, $wpdb );            
        }
        
    }

   
    if( !empty( $meta_query ) ) {        
        if( !empty( $meta_query['joins'] ) ) {
            $args['join'][] = $meta_query['joins'];
        }

        if( !empty( $meta_query['wheres'] ) ) {
            $args['where'][] = $meta_query['wheres'];
        }
        
    }

    if( !empty( $tax_query ) ) {        
        if( !empty( $tax_query['joins'] ) ) {
            $args['join'][] = $tax_query['joins'];
        }

        if( !empty( $tax_query['wheres'] ) ) {
            $args['where'][] = $tax_query['wheres'];
        }
        
    }

    $wheres = array_merge( $pre_qry_where , $args['where'] );    
    
    if( isset( $args['join'] ) ) {
        $joins = array_merge( $pre_qry_join , $args['join'] );
    }
    
    

    $a = $args;
    $select = 'posts.ID';
    
    $wheres = implode( " ", $wheres  );
    
    if( $joins ) {
        $joins = implode( " ", $joins );
    }
    
    $sql = "SELECT DISTINCT $select FROM {$wpdb->prefix}posts AS posts $joins WHERE $wheres $order";
    $sql = trim(preg_replace('/\s+/', ' ', $wpdb->prepare( $sql, $prepare_args ) ));
            
    $total_query = "SELECT COUNT(1) FROM (${sql}) AS combined_table";		
    $total_properties = $wpdb->get_var( $total_query ); 


    if( isset( $args['paginate'] ) ) {
        $paginate = $args['paginate'];
    }

    if( $paginate ) {
       
        $offset = ( $current_page * $per_page ) - $per_page;
            
        if( $per_page != '-1') {
            $limit = " LIMIT {$offset}, {$per_page}";
        }
        $sql = $sql . $limit;
        
        $big = 999999999;
         
        $paginate = paginate_links( array(
            //'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'base' => preg_replace('/\?.*/', '/', get_pagenum_link(1)) . '%_%',
            'format' => '?cpage=%#%',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => ceil($total_properties / $per_page),
            'current' => $current_page
        )); 

    } else {
        $limit = " LIMIT 0, {$per_page}";
        $sql = $sql . $limit;
    }

    $sq = $wpdb->get_results( $sql , 'ARRAY_A' );
    	
        
    if( $sq ) {
        foreach( $sq as $post ) {
            $list[] = $post['ID'];
        }
        
        $result['data'] 	= $list;
        $result['pager']	= $paginate;

        return $result;
    } else {
        return false;
    }

}
}