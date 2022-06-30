<?php
    
 	$related_project_heading = '';
	$related_project_blurb = '';
	
	$listing_option = _get_sub_field_value('cpts_project_list_option');
	$args = array(
		'post_type'         => 'project',
		'posts_per_page'    => -1,
		'post_status'       => 'publish'
	);

	if( is_array($listing_option) ? (isset($listing_option['featured_projects']) ? $listing_option['featured_projects'] : false ) : false ){
		$args['meta_query'] = array(
			'relation'  => 'AND',
			array(
				'key' => 'hic_featured_post',
				'value' => 1,
				'compare' => '==' // not really needed, this is the default
			)
		);

	}else{
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'DESC';
	}
	
	if($term->slug) 
		$args['tax_query'] = array(
			array(
				'taxonomy'  => 'project_cat',
				'field'     => 'slug', 
				'terms'     => $term->slug,
				'operator' => 'IN'
			)
		);

	$list = array();
	$q = new WP_Query( $args );

	if($q->have_posts()) : while($q->have_posts()) : $q->the_post();
		array_push($list, get_the_ID());
	endwhile; endif; wp_reset_postdata();
	
	$feature_project_list = array($list);
    echo $h::generate_projects_listing( $related_project_heading , $related_project_blurb, $feature_project_list , '', '', $listing_option ); 
?>