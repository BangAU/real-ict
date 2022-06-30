<?php
/**
 * The template part for displaying an author byline
 */
?>

<?php $single_post_byline = get_field('single_post_meta_options','options'); ?>

<?php if(is_array($single_post_byline)) : ?>

<ul class="no-bullet post-byline"><?php
	// printf( __( 'Posted on %1$s by %2$s - %3$s', 'jointswp' ),
	// 	get_the_time( __('F j, Y', 'jointswp') ),
	// 	get_the_author_posts_link(),
	// 	get_the_category_list(', ')
	// );

		if(in_array('date', $single_post_byline)) {
			echo '<li class="published-date"><span>Posted on </span>' . get_the_time( __('F j, Y', 'jointswp') ) . '</li>';
		}
		if(in_array('author', $single_post_byline)) {
			echo '<li class="author"><span>by</span> ' . get_the_author(). '</li>';
		}
		if(get_the_category_list(', ') && in_array('category', $single_post_byline)) {
			echo '<li class="category">' . get_the_category_list(', '). '</li>';
		}
		
?></ul>	
<?php endif; ?>