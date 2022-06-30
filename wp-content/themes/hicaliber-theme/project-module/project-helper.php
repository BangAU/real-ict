<?php

class PROJECT_HELPER {

    public static function split_ids( $ids = array() ) {
        $sp_id = array(); 
        if( $ids ) {
            foreach( $ids as $key => $id ) { 
                $sp_id[] = $id[key($id)];
            }
        }
        return $sp_id;
    }

    public static function get_image( $id ) {
        if ( $id ) {
            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
            return $large_image_url[0];
        } else {
            return "";
        }
    }

    public static function get_project( $range_type = "",  $cat = "", $ids = array()  ) {
        
        $data = [];
        
        $args = array(
            'post_type' =>  "project",
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );

        if( $ids ){
            $id = self::split_ids( $ids );
            $args[ 'post__in' ] = $id;
        }
        
        if( $cat  ){
            $args['tax_query'] = array(
        		array(
        			'taxonomy'  => 'project_cat',
        			'field'     => 'slug', 
        			'terms'     => $cat,
        			'operator' => 'IN'
        		)
        	);
        }

        $q = new WP_Query( $args );

        if( $q->have_posts() ){

            while( $q->have_posts() ) {
                $q->the_post();
                $id = get_the_ID();
                $data[] = array(
                    'id' => $id,
                    'title' => get_the_title(),
                    'link' => get_the_permalink(),
                    'img' => self::get_image( $id ),
                    'description' => get_the_content(),
                    'excerpt' => get_the_excerpt()
                );
            }
        }
        
        wp_reset_postdata();
        return $data;
    }

    public static function set_listing_button_label() {

        $label = "Read more";

        $listing_button_settings = _get_field_value('pjgs_action_btn_main');

        $label = $listing_button_settings['label'];

        return $label;
    }

}