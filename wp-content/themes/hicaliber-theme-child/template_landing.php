<?php /* Template Name: Bang Landing Page */ 


/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package real-ict
 */

get_header(); ?>
<main class="sitecontent">


    <?php if ( have_posts() ) : ?>

    <?php
	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		/*
		 * Include the Post-Type-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		 */
		the_content();

	endwhile;


else :

	echo 'No content found';

endif; ?>
</main>
<?php
get_footer();