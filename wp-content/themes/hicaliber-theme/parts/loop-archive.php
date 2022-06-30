<?php
/**
 * Template part for displaying posts
 *
 * Used for single, index, archive, search.
 */

//Variables
$content = wp_trim_words(get_the_content(), 35);
if(has_excerpt()) {
	$content = get_the_excerpt();
}
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full' );
$link = get_permalink(); 

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article">	

	<div class="hic-box<?php echo ($featured_image) ? ' has-image' : ''; ?>">
		
		<?php if($featured_image) : ?>	
			<div class="hic-image-container">
				<a href="<?php echo $link; ?>">
					<div class="hic-image" style="background-image: url(<?php echo $featured_image; ?>)"></div>	
				</a>				
			</div>			
		<?php endif; ?>

		<div class="hic-content">
						
		<header class="article-header">
			<h3 class="hic-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<?php get_template_part( 'parts/content', 'byline' ); ?>
		</header> <!-- end article header -->
				
		<div class="entry-content hic-blurb" itemprop="text">

			<?php if($content) : ?>	
				<?php echo $content; ?>
			<?php endif; ?>
				<div class="hic-button-wrap">
					<a class="button" href="<?php echo $link; ?>">Read more</a>	
				</div>			
			</div> <!-- end article section -->	
		

		</div>
	</div>

	<?php 
	/* 
	<footer class="article-footer">
    	<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'jointswp') . '</span> ', ', ', ''); ?></p>
	</footer> <!-- end article footer -->	
	*/ ?>		

</article> <!-- end article -->
