<?php
/**
 * Template part for displaying a single post
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	
	<?php 

		$show_article_header = true;

		if(is_singular('location')) {
			$banner_options = _get_field_value('location_single_banner_options','options');
		} elseif(is_singular('location_post')) {
			$banner_options = _get_field_value('location_post_single_banner_options','options');
		} else {
			$banner_options = _get_field_value('post_single_banner_options', 'options');
		}

	    if($banner_options == '' || $banner_options && $banner_options['show_page_banner']) {
	       $show_article_header = false; 
	    } 

	    if(_get_field_value('show_page_banner') == false) {
	    	$show_article_header = true;
	    }
	    $title_location = isset($banner_options['title_location']) ? $banner_options['title_location'] : 'title-above-image';

	    if($show_article_header && $title_location == 'title-above-image') :
	 ?>
		<?php hic_article_header(); ?>
	<?php endif; ?>				

    <section class="entry-content" itemprop="text">

		
		<?php 
			if($show_article_header) :
				the_post_thumbnail('full'); 
			endif;			
			?>

		<?php if($show_article_header && $title_location == 'title-below-image') : ?>
			<?php hic_article_header(); ?>
		<?php endif; ?>

		<?php the_content(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer">
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jointswp' ), 'after'  => '</div>' ) ); ?>
		<p class="tags"><?php the_tags('<span class="tags-title">' . __( 'Tags:', 'jointswp' ) . '</span> ', ', ', ''); ?></p>	
	</footer> <!-- end article footer -->
						
	<?php comments_template(); ?>	
													
</article> <!-- end article -->

<?php 
	function hic_article_header() {
		?>
			<header class="article-header">	
				<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
				<?php get_template_part( 'parts/content', 'byline' ); ?>
		    </header> <!-- end article header -->	

		<?php
	}
 ?>