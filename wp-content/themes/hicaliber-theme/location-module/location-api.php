<?php

class B_Query_location {

    public static $args = [];
    public static $placeholder = ['location','publish'];

    const location_meta_key = [        
        'location_contact_person',
        'location_contact_person_position',
        'location_phone',
        'location_address',
        'location_email_address',
        'location_website_url',
        'location_social_facebook',
        'location_social_google_plus',
        'location_social_twitter',
        'location_social_linkedin',
        'location_social_instagram',
        'location_social_youtube',
        'location_latitude',
        'location_longitude',
		'location_direction',
        'gallery',
        'post_rating',
        'map_marker_default',
        'map_marker_selected',
    ];

    public static function sql_conditions( $q , $meta ) {
        $v = [];
        switch ( $q['condition'] ) {
            case "ss" :
                break;
            case "<>" :
                $v['relation']          = self::compare_vvalues( $q , $meta );
                $v['placeholder_value'] = $q['value'];
                break;
            default :
                $v['relation']          = "{$q['relation']} {$meta}.meta_value = %s";
                $v['placeholder_value'] = $q['value'];
        }
        return  $v;
    }

    public static function build_qry_where( $a ) {
        $rel = [];
        $placeholder = [];
        
        foreach( $a as &$v ) {
           $rel['rel'][] = $v['relation'];
        
            if( count( $v['placeholder_value'] ) > 1 ){
                foreach( $v['placeholder_value'] as $fg ) {
                    if( $fg ) {
                        $placeholder[] = $fg;
                    }
                }
            } else {
                $placeholder[] = $v['placeholder_value'];
            }

        }
    
        $rel['rel'] = implode( " ", $rel['rel'] );
        $rel['placeholder'] = $placeholder;
        return $rel;
    }

    public static  function get_mmeta( $properties ) {
        $all_meta = array();

        foreach ($properties as $key => $property ) {
            // CLEAR STORE META
            $store_meta = [];
            $id = $property->ID;
            $custom_fields = get_post_custom( $id );
            $inspection_index = "";

            if( isset( $property->inspection_date ) ) {
                $inspection_index = str_replace("n_start_time", "", $property->inspection_date );
            }            
            foreach( $custom_fields as $key => $custom_feild ) {
                
                $store_meta['id'] = (int) $id;
                $store_meta['name'] = get_the_title( $id );
                $store_meta['permalink'] = get_permalink($id);
                $store_meta['featured_image_small'] = get_the_post_thumbnail_url( $id );
                $store_meta['featured_image'] = get_featured_image( $id );
                $store_meta['location_contact_person_avatar'] = get_field('location_contact_person_avatar', $id );
                $store_meta['location_opening_hours'] = get_field('location_opening_hours', $id );

                
                if(has_excerpt($id)) {
                    $store_meta['excerpt'] = get_the_excerpt( $id );
                } else {

                    $content_post = get_post($id);
                    $content = $content_post->post_content;
                    $content = wp_trim_words($content , 25, '...');
                                 
                    $store_meta['excerpt'] = $content;    
                }

                $terms = get_the_terms($id, 'location_cat');
                if(is_array($terms) && !empty($terms)){
					$store_meta['category_image_icon'] = get_field('cat_map_image_icon', $terms[0]);
                    $store_meta['map_marker_default'] = get_field('cat_map_default_marker', $terms[0]);
                    $store_meta['map_marker_selected'] = get_field('cat_map_selected_marker', $terms[0]);
                }

                if( in_array($key, self::location_meta_key ) ) {
                    if( is_serialized( $custom_feild[0] , true ) ) {
                        $store_meta[$key] = unserialize(  $custom_feild[0] );
                    } else {
                        $store_meta[$key] = $custom_feild[0];
                    }
                }
                $store_meta['contact_details_label'] = _get_field_value( 'ls_contact_details_label', 'options' );
                $store_meta['phone_label'] = _get_field_value( 'ls_phone_number_label', 'options' );
                $store_meta['email_label'] = _get_field_value( 'ls_email_address_label', 'options' );
                $store_meta['opening_hours_label'] = _get_field_value( 'ls_opening_hours_label', 'options' );
                $store_meta['website_label'] = _get_field_value( 'ls_visit_website_label', 'options');
                $store_meta['learn_more_label'] = _get_field_value( 'ls_learn_more_label', 'options');
            }
            $all_meta[] = $store_meta;
        }
       return $all_meta;
    }

    public static function build_query( $args ) {

        global $wpdb;

        $placeholder_values = ['publish'];
        $order = "";
        $joins = "";

        $select = implode( ", ", $args['select'] );
       
        if( isset( $args['join'] ) ) {
            $joins = implode( " ", $args['join'] );
        }

        if( !empty( $args['order'] ) ) {
            $order = $args['order'];
        }
        
        $wheres = implode( " " , $args['where']);

        $sql = "SELECT $select FROM {$wpdb->prefix}posts AS posts $joins WHERE $wheres $order";
        
        $sql = trim(preg_replace('/\s+/', ' ', $wpdb->prepare( $sql, $placeholder_values ) )) ;
    
        /**
         * Get the Total properties
         */
        $total_query = "SELECT COUNT(1) FROM (${sql}) AS combined_table";
        $total_properties = $wpdb->get_var( $total_query );  

        /**
         * Set Pagination
         */

        $page       = (int) $args['page'] ;
        $per_page   = (int) $args['per_page'];
        
        $offset = ( $page * $per_page ) - $per_page;

        
        $data['total_properties'] = $total_properties;
        $data['per_page'] = $per_page;
        
        $final_sql = $sql . $order . " LIMIT ".$offset.", ".$per_page;

        $data['sql'] = $final_sql;
        
        $sq = $wpdb->get_results( $final_sql );

        /**
         *  Pagenation Link
         * */   

        $big = 999999999;

        $current_page = max(1, $page );

        $data['current_page']   = $current_page;

        /*
        $data['page_button'] = paginate_links( array(
            'base' => get_pagenum_link(1) . '&cpage=%#%',
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'end_size' => 2,
            'total' => ceil($total_properties / $per_page),
            'current' => $current_page
        ));  
        */
    
        $data['data'] = self::get_mmeta( $sq );
       
        return $data;

    }

    /*************************************************** 
     * COMPARE META FIELD
    ****************************************************/

    public static function compare_meta_gt_lt( $meta_name , $compare , $post_meta ) {
        
        $sql = false;

        if( isset( $compare['min']  ) &&  $compare['min'] != "" || isset( $compare['max']  ) && $compare['max'] != "" ) {
            
            $min = $compare['min'];
            $max = $compare['max'];
            
            $sql['join'] = self::write_join( 'INNER', $meta_name , $post_meta );
            if( $min != "" && $max != "" ) {
                $sql['where'] = "AND {$meta_name}.meta_value BETWEEN {$min} AND {$max}";
            } 
            // min
            if( $min != "" && $max == "" ) {
                $sql['where'] = "AND {$meta_name}.meta_value >= $min";
            } 
            // max
            if( $min == "" &&   $max != "" ) {
                $sql['where'] = "AND {$meta_name}.meta_value <= $max";
            }
        }

        return $sql;
           
    }

    /*************************************************** 
     * JOIN QUERY HELPER
    ****************************************************/

    public static function write_join( $type = "INNER" , $key , $meta , $condition = "=" ) {
        global $wpdb;
        return "{$type} JOIN $wpdb->postmeta AS {$key} ON {$key}.post_id = posts.ID AND {$key}.meta_key {$condition} '{$meta}'";
    }

    /*************************************************** 
     * CREATE THE QUERY RESPONSE FOR PROPERTIES
    ****************************************************/

    public static function create_response( $request ){
        
        global $wpdb;
         
        $result = "";        
        $pagination = true;
        $parameters = $request->get_query_params();
        $surrounding_search = false;
        $latlng = "";


        if( isset( $parameters['pagination'] ) ) {
            $pagination = $parameters['pagination'];
        }


        $per_page = isset( $parameters['per_page'] ) ? $parameters['per_page'] : 5;
        $per_page = 100;
        $search_radius = 50;
    
        if( isset( $parameters['surrounding_suburbs'] ) && $parameters['surrounding_suburbs'] == 1 ) {
            $surrounding_search = true;
            $search_radius = _get_field_value( 'op_surrounding_suburbs_radius' , 'options' ) ? _get_field_value( 'op_surrounding_suburbs_radius' , 'options' ) : 50;
        }
        
        $a = [
            'page' =>  isset( $parameters['page'] ) ? $parameters['page'] : 1 ,
            'per_page' => $per_page
        ];
        
        $a['select'] = ['posts.ID'];
        $a['where'][] = "posts.post_status = %s";
        $a['where'][] = "AND posts.post_type = 'location'";
        $a['where'][] = "AND posts.post_title != ''";
        
        $post_id = url_to_postid(wp_get_referer());
        $current_post = get_post($post_id);
        if($current_post->post_type == 'location'){
            $a['where'][] = "AND posts.ID = '" . $post_id . "'";
        }
        
        $a['join'][] = self::write_join( 'INNER', 'latitude' , 'location_latitude' );
        $a['join'][] = self::write_join( 'INNER', 'longitude' , 'location_longitude' );
        $a['where'][] = "AND latitude.meta_value != ''";
        $a['where'][] = "AND longitude.meta_value != ''";
        
        
        
        foreach( $parameters as $key =>  $val ) {
            
            $meta_value = $key.".meta_value";

            if( $val && $val != "any"  ) {
                
                if( !is_array( $val  ) ) {
                    $val = sanitize_text_field( $val );
                } 

                switch ( $key ) : 
    
                    case 'latlng':
                   
                        if( $surrounding_search ): 
                            $latlng = explode("|", $val );
                            $a['select'][] = "( 6371 * acos( cos( radians( {$latlng[0]} ) ) * cos( radians( latitude.meta_value ) ) * cos( radians( longitude.meta_value ) - radians( {$latlng[1]} ) ) + sin( radians( {$latlng[0]}) ) * sin( radians( latitude.meta_value ) ) ) ) AS distance";
                            $a['join'][] = self::write_join( 'INNER', 'latitude' , 'location_latitude' );
                            $a['join'][] = self::write_join( 'INNER', 'longitude' , 'location_longitude' );
                            $a['order'] = "ORDER BY distance ASC";
                        endif;
                    
                    break;

                    case 'ids':
                        
                        if( 'featured' == $val ) {
                            $a['join'][] = self::write_join( 'INNER', 'featured' , 'post_featured' );
                            $a['where'][] = "AND featured.meta_value = '1'"; 
                        } else {
                            $a['where'][] = "AND posts.ID IN ({$val})";    
                        }
                        
                        
                    break;
        
                endswitch;
            } 
        }
        
        if( !empty( $parameters['category'] ) ) {
            $scl = $parameters['category'];
            $a['join'][] = "INNER JOIN $wpdb->term_relationships ON (posts.ID = $wpdb->term_relationships.object_id)";
            $a['join'][] = "INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id AND $wpdb->term_taxonomy.taxonomy='location_cat')";
            $a['join'][] = "INNER JOIN $wpdb->terms ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id )";
            $a['where'][] = "AND $wpdb->terms.term_id IN ({$scl})"; 
        }
        
     
        if( $surrounding_search && $latlng ): 
            $a['where'][] = "HAVING distance < {$search_radius}";
        endif;
   
        $data = self::build_query( $a ) ;

        
        $result = [ 'data' => $data['data']  ];

        if( true ) {

            $result['debug'] = [
                'statements'    => $a,
                'sql'           => $data['sql'],
                'params'        => $parameters,
            ];

        }

        if( $pagination && isset($data['page_button'])) { 
            $result['page_button'] = $data['page_button'];
        }

        if( $data ) {
            $response = new WP_REST_Response( $result , 200);
            $response->header( 'X-WP-Total', $data['total_properties'] ); 
            $response->header( 'X-WP-TotalPages', $data['per_page']   );
            $response->header( 'X-WP-CurrentPage', $data['current_page']  );
            $response->header( 'Cache-Control', 'no-cache'  );
            return $response;
        } else {
            return ['error'];
        }
    }

    function locations( \WP_REST_Request $request ){
        return self::create_response( $request );
    }


    public function __construct(){
        
        /************************************************
         * Multiple properties end point
         ***********************************************/ 
        
        add_action('rest_api_init', function() {
            register_rest_route('hi-api/v1', 'locations', [
                'methods' => WP_REST_Server::READABLE,
                'callback'  => [$this , 'locations' ],
                'args'      => [
                    'per_page'  => [
                        'default' => 10,
                        'sanitize_callback' => 'absint',
                    ],
                    'page'  => [
                        'default' => 1,
                        'sanitize_callback' => 'absint',
                    ],
                ],
				'permission_callback' => '__return_true',
            ]);
        });



    }

}

new B_Query_location();